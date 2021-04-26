<?php
namespace App\Application\Service;

use App\Application\Response\ClientListResponse;
use App\Domain\Entity\Client;
use App\Domain\Entity\ClientList;

class ClientFormatter
{
    private int $name;
    private int $email;
    private int $phone;
    private int $company;

    private ClientListResponse $list;

    private string $format;
    private string $separator;

    public function __construct(ClientListResponse $list)
    {
        $this->format = $this->separator = "";
        $this->name = $this->email = $this->phone = $this->company = 0;
        $this->list = $list;

        $this->configurate();
    }

    private function configurate(): void
    {
        /** @var Client $client */
        foreach($this->list->value() as $item) {
            $this->name = $this->bigger($item['name'], $this->name);
            $this->email = $this->bigger($item['email'], $this->email);
            $this->phone = $this->bigger($item['phone'], $this->phone);
            $this->company = $this->bigger($item['company'], $this->company);
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