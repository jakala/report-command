<?php
namespace App\Infrastructure\Exception;

class FileNotFoundException extends \Exception
{
    private string $details;

    public function __construct(string $details)
    {
        $this->details = $details;
        parent::__construct();
    }

    public function getDetails() : string
    {
        return $this->details;
    }
}