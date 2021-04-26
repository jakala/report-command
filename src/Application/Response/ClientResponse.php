<?php

namespace App\Application\Response;


use App\Domain\Entity\Client;

class ClientResponse
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function value() : array
    {
        return  [
            'name' => $this->client->getName()->value(),
            'email' => $this->client->getEmail()->value(),
            'phone' => $this->client->getPhone()->value(),
            'company' => $this->client->getCompany()->value()
        ];
    }
}