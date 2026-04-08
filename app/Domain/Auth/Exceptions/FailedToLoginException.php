<?php

namespace App\Domain\Auth\Exceptions;

class FailedToLoginException extends AuthException
{
    public function __construct()
    {
        parent::__construct(
            __('Sorry, the provided credentials are incorrect.')
        );
    }
}
