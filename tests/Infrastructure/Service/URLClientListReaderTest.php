<?php
namespace App\Tests\Infrastructure\Service;

use App\Application\Response\ClientListResponse;
use App\Infrastructure\Service\URLClientListReader;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Infrastructure\Service\URLClientListReader
 * @covers \App\Application\Response\ClientListResponse
 * @covers \App\Application\Response\ClientResponse
 * @covers \App\Domain\Entity\Client
 * @covers \App\Domain\ValueObject\Email
 * @covers \App\Domain\ValueObject\Phone
 * @covers \App\Domain\ValueObject\Shared\StringValueObject
 */

class URLClientListReaderTest extends TestCase
{
    private const URL = 'https://web.archive.org/web/20210414050626if_/https://jsonplaceholder.typicode.com/users';

    /** @test */
    public function should_return_a_client_list_response(): void
    {
        $urlReader = new URLClientListReader();
        $response = $urlReader->read(self::URL);

        self::assertInstanceOf(ClientListResponse::class, $response);
    }
}
