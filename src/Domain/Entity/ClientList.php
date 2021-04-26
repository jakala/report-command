<?php
namespace App\Domain\Entity;

class ClientList
{
    /** @var array $list */
    private array $list;

    public function __construct()
    {
        $this->client = [];
    }

    /**
     * @param Client $client
     */
    public function addClient(Client $client): void
    {
        $this->list[] = $client;
    }

    /**
     * @param ClientList $list
     */
    public function mergeClientList(ClientList $list) :void
    {
        foreach($list->getList() as $client) {
            $this->addClient($client);
        }
    }

    /**
     * @return array
     */
    public function getList() : array
    {
        return $this->list;
    }

}