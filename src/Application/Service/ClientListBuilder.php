<?php
namespace App\Application\Service;

use App\Domain\Entity\ClientList;

class ClientListBuilder
{
    /** @var ClientBuilder $reader */
    private ClientBuilder $reader;

    public function __construct(ClientBuilder $reader)
    {
        $this->reader = $reader;
    }
    public function __invoke(array $list) : ClientList
    {
        $result = new ClientList();
        foreach($list as $item) {
            $client = $this->reader->__invoke($item);
            $result->addClient($client);
        }
        return $result;
    }
}