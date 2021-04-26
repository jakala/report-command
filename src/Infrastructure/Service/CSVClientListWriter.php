<?php
namespace App\Infrastructure\Service;

use App\Application\Service\ClientFormatter;
use App\Domain\Entity\Client;
use App\Domain\Entity\ClientList;
use App\Domain\Interface\ListWriter;

class CSVClientListWriter implements ListWriter
{
    private ClientFormatter $formatter;

    public function write(ClientList $list, string $file): bool
    {
        $formatter = new ClientFormatter($list);
        $format = $formatter->getFormat();
        $separator = $formatter->getSeparator();

        $file = fopen($file, 'w');
        $this->writeHeader($file, $format);
        $this->writeSeparator($file, $separator);
        $this->writeClientList($file, $list, $format);

        fclose($file);
        return true;
    }

    private function writeHeader($file, string $format)
    {
        $head = sprintf($format, 'Nombre', 'Email', 'Telefono', 'Empresa');
        fputs($file, $head);
    }

    private function writeSeparator($file, string $separator)
    {
        fputs($file, $separator);
    }

    private function writeClientList($file, ClientList $list, string $format)
    {
        /** @var Client $client */
        foreach($list->getList() as $client) {
            $this->writeClientOnFile($client, $file, $format);
        }
    }

    private function writeClientOnFile(Client $client, $file, string $format)
    {
        $out = sprintf($format,
            $client->getName()->value(),
            $client->getEmail()->value(),
            $client->getPhone()->value(),
            $client->getCompany()->value()
        );
        fputs($file, $out);
    }
}