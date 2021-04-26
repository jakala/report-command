<?php

namespace App\Infrastructure\Command;

use App\Application\Service\ClientListMerger;
use App\Domain\Entity\ClientList;
use App\Domain\Interface\ListReader;
use App\Domain\Interface\ListWriter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCommand extends Command
{
    protected static string $defaultName='isalud:exportCSV';

    protected ListReader $xmlReader;
    protected ListReader $urlReader;
    protected ListWriter $csvWriter;

    public function __construct(
        ListReader $xmlReader,
        ListReader $urlReader,
        ListWriter $csvWriter
    ) {
        $this->xmlReader = $xmlReader;
        $this->urlReader = $urlReader;
        $this->csvWriter = $csvWriter;
        parent::__construct();
    }
    protected function configure():void
    {
        $this->setDescription('Generate CSV file with information from XML and /users');
        $this->setHelp('This command allows you to create a CSV file with information from XML or/and users from typicode.');

        $this->setDefinition(
            new InputDefinition([
                new InputArgument('output-file', InputArgument::REQUIRED,'name of the output file'),
                new InputOption('file','f', InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'File to read'),
                new InputOption('url', 'u', InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'URL for webservice')
            ])
        );
        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fileOutput = $input->getArgument('output-file');
        // get Options
        $files = $input->getOption('file');
        $urls = $input->getOption('url');
        if(empty($files) && empty($urls)) {
            die("nothing to generate in report");
        }
        $fileClientList = $this->readFiles($files);
        $urlsClientList = $this->readUrls($urls);



        $merge = new ClientList();
        $merge->mergeClientList($fileClientList);
        $merge->mergeClientList($urlsClientList);

        $csv = $this->csvWriter->write($merge, $fileOutput);

        return 1;
    }

    private function readFiles(array $files ): ClientList
    {
        $resultClientList= new ClientList();
        foreach($files as $file) {
            $clientList = $this->xmlReader->read($file);
            $resultClientList->mergeClientList($clientList);
        }
        return $resultClientList;
    }

    private function readUrls(array $urls ): ClientList
    {
        $resultClientList = new ClientList();
        foreach($urls as $url) {
            $clientList = $this->urlReader->read($url);
            $resultClientList->mergeClientList($clientList);
        }
        return $resultClientList;
    }
}
