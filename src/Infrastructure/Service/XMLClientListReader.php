<?php
namespace App\Infrastructure\Service;

use App\Application\Response\ClientListResponse;
use App\Application\Response\ClientResponse;
use App\Domain\Entity\Client;
use App\Domain\Interface\ListReader;
use App\Domain\ValueObject\Company;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Phone;
use Symfony\Component\DomCrawler\Crawler;

class XMLClientListReader implements ListReader
{
     public function read(string $list): ClientListResponse
    {
        $response = new ClientListResponse();
        $crawler = new Crawler(file_get_contents($list));
        $items = $crawler->children();

        /** @var \DOMElement $item */
        foreach($items as $item) {
            $client = new Client(
                new Name($item->getAttribute('name')),
                new Email($item->nodeValue),
                new Phone($item->getAttribute('phone')),
                new Company($item->getAttribute('company'))
            );
            $clientResponse = new ClientResponse($client);
            $response->addClientResponse($clientResponse);
        }

        return $response;
    }
}