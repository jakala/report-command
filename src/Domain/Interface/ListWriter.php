<?php
namespace App\Domain\Interface;

use App\Application\Response\ClientListResponse;

interface ListWriter
{
    public function write(ClientListResponse $list, string $file) : ?bool;
}
