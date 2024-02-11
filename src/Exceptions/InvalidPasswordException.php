<?php

namespace App\Exceptions;

use Exception;

class InvalidPasswordException extends Exception
{
    public function __construct(public $message)
    {
        parent::__construct(message: $this->message);
    }
}