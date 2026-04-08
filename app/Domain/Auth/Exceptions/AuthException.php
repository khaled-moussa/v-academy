<?php

namespace App\Domain\Auth\Exceptions;

use Exception;

abstract class AuthException extends Exception
{
    public function __construct(
        string $message,
        int $code = 0
    ) {
        parent::__construct($message, $code);
    }
}
