<?php
namespace App\Application\Service;

use App\Domain\Entity\Client;
use App\Domain\Entity\ClientList;

class ClientFormatter
{
    private int $name;
    private int $email;
    private int $phone;
    private int $company;

    private ClientList $clientList;

    private string $format;
    private string $separator;

    public function __construct(ClientList $clientList)
    {
        $this->format = $this->separator = "";
        $this->name = $this->email = $this->phone = $this->company = 0;
        $this->clientList = $clientList;

        $this->configurate();
    }

    private function configurate(): void
    {
        /** @var Client $client */
        foreach($this->clientList->getList() as $client) {
            $this->name = $this->bigger($client->getName()->value(), $this->name);
            $this->email = $this->bigger($client->getEmail()->value(), $this->email);
            $this->phone = $this->bigger($client->getPhone()->value(), $this->phone);
            $this->company = $this->bigger($client->getCompany()->value(), $this->company);
        }

        $this->format =  "|%-".$this->name."s".
            "|%-".$this->email."s".
            "|%-".$this->phone."s".
            "|%-".$this->company."s".PHP_EOL;

        $total = $this->name + $this->email + $this->phone + $this->company + 4;
        $separator = "%'-".$total."s".PHP_EOL;
        $this->separator = sprintf($separator, '');
    }

    private function bigger(string $value, int $actual)
    {
        return strlen($value) > $actual
            ? strlen($value)
            : $actual;
    }

    public function getFormat() :string
    {
        return $this->format;
    }

    public function getSeparator(): string
    {
        return $this->separator;
    }
}