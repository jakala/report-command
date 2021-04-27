<?php

namespace App\Domain\ValueObject\Shared;

abstract class StringValueObject
{
    /** @var string|null $value */
    private ?string $value;

    /**
     * StringValueObject constructor.
     * @param string|null $value
     */
    public function __construct(?string $value)
    {
        $this->value = $value;
    }

    /**
     * getter
     * @return string|null
     */
    public function value(): ?string
    {
        return $this->value;
    }
}
