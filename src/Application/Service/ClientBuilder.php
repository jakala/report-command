<?php
namespace App\Application\Service;

use App\Domain\Entity\Client;
use App\Domain\ValueObject\Company;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Phone;

class ClientBuilder
{
    public function __invoke(array $item) : Client
    {
        return new Client(
            new Name($item['name']),
            new Email($item['email']),
            new Phone($item['phone']),
            new Company($item['company'])
        );
    }
}