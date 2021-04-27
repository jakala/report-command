<?php
namespace App\Infrastructure\Service;

use App\Application\Response\ClientListResponse;
use App\Application\Service\ClientFormatter;
use App\Domain\Interface\ListWriter;

class CSVClientListWriter implements ListWriter
{
    public function write(ClientListResponse $list, string $file): ?bool
    {
        //prepare output format
        $formatter = new ClientFormatter($list);
        $format = $formatter->getFormat();
        $separator = $formatter->getSeparator();

        // write file with header, separator and data
        $file = fopen($file, 'w');
        $this->writeHeader($file, $format);
        $this->writeSeparator($file, $separator);
        $this->writeData($file, $list, $format);
        fclose($file);

        return true;
    }

    private function writeHeader($file, string $format)
    {
        fputs($file, sprintf($format, 'Nombre', 'Email', 'Telefono', 'Empresa'));
    }

    private function writeSeparator($file, string $separator)
    {
        fputs($file, $separator);
    }

    private function writeData($file, ClientListResponse $list, string $format)
    {
        /** @var array $client */
        foreach ($list->value() as $client) {
            $out = sprintf($format, $client['name'], $client['email'], $client['phone'], $client['company']);
            fputs($file, $out);
        }
    }
}
