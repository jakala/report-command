<?php

namespace App\Infrastructure\Command;

use App\Application\Response\ClientListResponse;
use App\Domain\Interface\ListReader;
use App\Domain\Interface\ListWriter;
use App\Infrastructure\Exception\FileNotFoundException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

set_error_handler(function($errno, $errstr) {
    throw new \Exception( $errstr, $errno);
}, E_WARNING);


class ImportCommand extends Command
{
    protected static $defaultName='isalud:import';

    protected static string $URL = 'https://web.archive.org/web/20210414050626if_/https://jsonplaceholder.typicode.com/users';
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
        $io = new SymfonyStyle($input, $output);
        // get Argument and Options

        $fileOutput = $input->getArgument('output-file');
        $files = $input->getOption('file');

        // read URL
        $data = $this->readUrl();

        // si tenemos ficheros, leemos todos
        if (!empty($files)) {
            try {
                $fileClientListResponse = $this->readFiles($files);
                $data->mergeClientListResponse($fileClientListResponse);
            } catch(FileNotFoundException $e) {
                $io->getErrorStyle()->error($e->getDetails());
                die();
            }
        }
        // escribimos el csv en $fileOutput
        $this->csvWriter->write($data, $fileOutput);

        return 0;
    }

    /**
     * @param array $files
     * @return ClientListResponse
     * @throws FileNotFoundException
     */
    private function readFiles(array $files ): ClientListResponse
    {
        $resultClientList= new ClientListResponse();
        foreach($files as $file) {
            $clientList = $this->xmlReader->read($file);
            $resultClientList->mergeClientListResponse($clientList);
        }
        return $resultClientList;
    }

    private function readUrl(): ClientListResponse
    {
        return $this->urlReader->read(self::$URL);
    }
}
