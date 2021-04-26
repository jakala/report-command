<?php
namespace App\Domain\Interface;

use App\Domain\Entity\ClientList;

interface ListReader
{
    public function read(string $list) : ClientList;
}