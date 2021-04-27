<?php
namespace App\Application\Response;

class ClientListResponse
{
    private array $list;
    public function __construct()
    {
        $this->list =[];
    }

    public function addClientResponse(ClientResponse $client)
    {
        $this->list[] = $client;
    }

    public function getList() : array
    {
        return $this->list;
    }

    public function mergeClientListResponse(ClientListResponse $listResponse): void
    {
        /** @var ClientResponse $response */
        foreach ($listResponse->getList() as $response) {
            $this->addClientResponse($response);
        }
    }

    public function value() : array
    {
        $result = [];
        /** @var ClientResponse $response */
        foreach ($this->list as $response) {
            $result[] = $response->value();
        }

        return $result;
    }
}
