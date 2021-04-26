<?php
namespace App\Infrastructure\Service;

use App\Application\Service\ClientListBuilder;
use App\Domain\Entity\ClientList;
use App\Domain\Interface\ListReader;
use Symfony\Component\DomCrawler\Crawler;

class XMLClientListReader implements ListReader
{
    /** @var ClientListBuilder $builder */
    private ClientListBuilder $builder;

    public function __construct(ClientListBuilder $builder)
    {
        $this->builder = $builder;
    }

    public function read(string $list): ClientList
    {
        $crawler = new Crawler(file_get_contents($list));
        $items = $crawler->children();
        $result = [];

        /** @var \DOMElement $item */
        foreach($items as $item) {
            $result[] = [
                'name' => $item->getAttribute('name'),
                'email' => $item->nodeValue,
                'phone' => $item->getAttribute('phone'),
                'company' => $item->getAttribute('company')
            ];
        }

        return $this->builder->__invoke($result);
    }
}