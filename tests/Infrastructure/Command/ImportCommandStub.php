<?php
namespace App\Tests\Infrastructure\Command;

use App\Application\Response\ClientListResponse;
use App\Infrastructure\Command\ImportCommand;

class ImportCommandStub extends ImportCommand
{
    public function readFiles( array $files) : ClientListResponse
    {
        return $this->readFiles($files);
    }
}