<?php

namespace App\Domain\Exception;

class WrongPhoneNumberException extends \Exception
{
    protected  $message= "Wrong Phone number format";
}