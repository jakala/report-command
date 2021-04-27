<?php
namespace App\Tests\Infrastructure\Service;

use App\Application\Response\ClientListResponse;
use App\Infrastructure\Exception\FileNotFoundException;
use App\Infrastructure\Service\XMLClientListReader;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Infrastructure\Service\XMLClientListReader
 * @covers \App\Application\Response\ClientListResponse
 * @covers \App\Application\Response\ClientResponse
 * @covers \App\Domain\Entity\Client
 * @covers \App\Domain\ValueObject\Email
 * @covers \App\Domain\ValueObject\Phone
 * @covers \App\Domain\ValueObject\Shared\StringValueObject
 * @covers \App\Domain\Interface\ListReader
 * @covers \App\Domain\ValueObject\Company
 * @covers \App\Domain\ValueObject\Name
 */
class XMLClientListReaderTest extends TestCase
{
    private const xml_file = "./tests/data/clients.xml";
    /** @test */
    public function should_return_a_client_list_response_from_file() : void
    {
        $xmlReader = new XMLClientListReader();
        $response = $xmlReader->read(self::xml_file);

        self::assertInstanceOf(ClientListResponse::class, $response);
    }
}
