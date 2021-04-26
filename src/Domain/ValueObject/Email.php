<?php
namespace App\Domain\ValueObject;

use App\Domain\Exception\EmptyEmailException;
use App\Domain\ValueObject\Interface\Validable;
use App\Domain\ValueObject\Shared\StringValueObject;

class Email extends StringValueObject implements Validable
{
    public function __construct(string $value)
    {
        $this->validate($value);
        parent::__construct($value);
    }

    /**
     * @param string|null $value
     * @throws EmptyEmailException
     */
    public function validate(?string $value): void
    {
        empty($value) && throw new EmptyEmailException();
    }
}