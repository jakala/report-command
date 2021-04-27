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
use App\Infrastructure\Exception\FileNotFoundException;
use Symfony\Component\DomCrawler\Crawler;

class XMLClientListReader implements ListReader
{
    /**
     * @throws FileNotFoundException
     */
    public function read(string $list): ClientListResponse
    {
        $items = [];
        $response = new ClientListResponse();
        try {
            $content = file_get_contents($list);
            $crawler = new Crawler($content);
            $items = $crawler->children();
        } catch (\Throwable $e) {
            throw new FileNotFoundException(sprintf("file '%s' not exists.", $list));
        }

        /** @var \DOMElement $item */
        foreach ($items as $item) {
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
