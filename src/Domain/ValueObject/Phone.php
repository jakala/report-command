<?php
namespace App\Domain\ValueObject;

use App\Domain\Exception\WrongPhoneNumberException;
use App\Domain\ValueObject\Interface\Validable;
use App\Domain\ValueObject\Shared\StringValueObject;

class Phone extends StringValueObject implements Validable
{
    public function __construct(?string $value)
    {
        $this->validate($value);
        parent::__construct($value);
    }

    /**
     * @param string|null $value
     * @throws WrongPhoneNumberException
     */
    public function validate(?string $value): void
    {
        // 463-170-9623 x156
        list($first, $second, $third, $four) = sscanf($value, "%d-%d-%d %s");
        //if(!is_numeric($first) || !is_numeric($second) || !is_numeric($third)) {
        //    throw new WrongPhoneNumberException();
        //}
    }
}
