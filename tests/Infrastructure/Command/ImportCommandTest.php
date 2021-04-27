<?php

namespace App\Tests\Infrastructure\Command;

use App\Application\Response\ClientListResponse;
use App\Domain\Interface\ListReader;
use App\Domain\Interface\ListWriter;
use App\Infrastructure\Exception\FileNotFoundException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
        $dependencies = $this->getCommandDependencies();
        $command = $this->getCommand($dependencies);
        self::assertEquals('Generate CSV file with information from XML and /users',$command->getDescription());
        self::assertEquals(
            'This command allows you to create a CSV file with information from XML or/and users from typicode.',
            $command->getHelp()
        );
    }

    /** @test */
    public function should_call_read_method_in_url_reader(): void
    {
        $dependencies = $this->getCommandDependencies();
        $dependencies['xmlReader']
            ->method('read')
            ->willReturn(new ClientListResponse());
        $dependencies['urlReader']
            ->method('read')
            ->willReturn(new ClientListResponse());

        $input = $this->createMock(InputInterface::class);
        $input
            ->method('getArgument')
            ->with('output-file')
            ->willReturn('report.xml');
        $input
            ->method('getOption')
            ->with('file')
            ->willReturn(['file1']);
        $output= $this->createMock(OutputInterface::class);
        $command = $this->getCommand($dependencies);
        $result = $command->execute($input, $output);

        self::assertEquals(0, $result);
    }

    /** @test */
    public function should_catch_file_not_found_exception(): void
    {
        $dependencies = $this->getCommandDependencies();
        $dependencies['xmlReader']
            ->method('read')
            ->willThrowException(new FileNotFoundException("file not found"));

        $input = $this->createMock(InputInterface::class);
        $input
            ->method('getOption')
            ->with('file')
            ->willReturn(['file1']);
        $output= $this->createMock(OutputInterface::class);
        $command = $this->getCommand($dependencies);
        $result = $command->execute($input, $output);
        $this->assertEquals(1, $result);
    }

    private function getCommand(array $dependencies) : ImportCommandStub
    {
        return new ImportCommandStub(
            $dependencies['xmlReader'],
            $dependencies['urlReader'],
            $dependencies['csvWriter']
        );
    }

    private function getCommandDependencies(): array
    {
        return [
            'xmlReader' => $this->createMock(ListReader::class),
            'urlReader' => $this->createMock(ListReader::class),
            'csvWriter' => $this->createMock(ListWriter::class),
        ];
    }
}
