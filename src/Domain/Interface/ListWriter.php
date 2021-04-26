<?php
namespace App\Domain\Interface;

use App\Domain\Entity\ClientList;

interface ListWriter
{
    public function write(ClientList $list, string $file) : bool;
}