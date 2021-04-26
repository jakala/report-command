<?php
namespace App\Domain\Interface;

use App\Application\Response\ClientListResponse;
use App\Infrastructure\Exception\FileNotFoundException;

interface ListReader
{
    /** @throws FileNotFoundException */
    public function read(string $list) : ClientListResponse;
}