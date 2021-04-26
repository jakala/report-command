<?php
namespace App\Infrastructure\Service;

use App\Application\Service\ClientListBuilder;
use App\Domain\Entity\ClientList;
use App\Domain\Interface\ListReader;
use Symfony\Component\DomCrawler\Crawler;

class URLClientListReader implements ListReader
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
        $response = $crawler->filter('body > p')->text();
        $items = json_decode($response, true);
        foreach($items as $item) {
            $result[] = [
                'name' => $item['name'],
                'email' => $item['email'],
                'phone' => $item['phone'],
                'company' => $item['company']['name']
            ];
        }

        return $this->builder->__invoke($result);
    }
}