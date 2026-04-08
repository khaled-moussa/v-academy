<?php

namespace App\Domain\Auth\Actions;

use Illuminate\Support\Facades\Auth;

class LogoutCurrentUserAction
{
    public function execute(): void
    {
        if (! auth()->check()) {
            return;
        }

        auth()->logout();

        session()->invalidate();
        session()->regenerateToken();
    }
}
