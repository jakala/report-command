<?php

namespace App\Tests\Infrastructure\Command;

use App\Application\Response\ClientListResponse;
use App\Domain\Interface\ListReader;
use App\Domain\Interface\ListWriter;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Infrastructure\Command\ImportCommand
 * @covers \App\Domain\Interface\ListReader
 * @covers \App\Domain\Interface\ListWriter
 */
class ImportCommandTest extends TestCase
{
    /** @test */
    public function should_method_configure_is_called(): void
    {
        $command = $this->getCommand();
        self::assertEquals('Generate CSV file with information from XML and /users',$command->getDescription());
        self::assertEquals(
            'This command allows you to create a CSV file with information from XML or/and users from typicode.',
            $command->getHelp()
        );
    }

    /** @test */
    public function should_call_read_method_in_url_reader(): void
    {
        $command = $this->getCommand();
        $command->readFiles([]);
    }

    private function getCommand() : ImportCommandStub
    {
        $xmlReader = $this->createMock(ListReader::class);
        $urlReader = $this->createMock(ListReader::class);
        $csvWriter = $this->createMock(ListWriter::class);
        return new ImportCommandStub($xmlReader, $urlReader, $csvWriter);
    }
}
