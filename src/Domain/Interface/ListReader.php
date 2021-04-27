<?php
namespace App\Domain\Interface;

use App\Application\Response\ClientListResponse;

interface ListReader
{
    public function read(string $list) : ClientListResponse;
}
