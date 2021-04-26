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

class URLClientListReader implements ListReader
{
    public function read(string $list): ClientListResponse
    {
        $crawler = new Crawler(file_get_contents($list));
        $list = $crawler->filter('body > p')->text();
        $items = json_decode($list, true);
        $response = new ClientListResponse();
        foreach($items as $item) {
            $client = new Client(
                new Name($item['name']),
                new Email($item['email']),
                new Phone($item['phone']),
                new Company($item['company']['name'])
            );
            $clientResponse = new ClientResponse($client);
            $response->addClientResponse($clientResponse);
        }
        return $response;
    }
}