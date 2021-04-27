<?php

namespace App\Domain\Exception;

class EmptyEmailException extends \Exception
{
    protected $message= "Name cannot be empty";
}
