<?php
namespace App\Infrastructure\Exception;

class FileNotFoundException extends \Exception
{
    protected $message = 'File not found';
}