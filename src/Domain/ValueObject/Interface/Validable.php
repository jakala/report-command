<?php
namespace App\Domain\ValueObject\Interface;

interface Validable
{
    public function validate(?string $value) : void;
}
