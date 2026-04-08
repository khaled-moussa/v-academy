<?php

namespace App\Domain\User\Actions;

use App\Domain\User\Models\User;
use Illuminate\Support\Facades\Auth;

class ResolveCurrentUserAction
{
    public function execute(array $with = []): ?User
    {
        return self::user($with);
    }

    /*
    |-----------------------------
    | Static: Current User ID
    |-----------------------------
    */
    public static function id(): ?int
    {
        return Auth::id();
    }

    /*
    |-----------------------------
    | Static: Current User Model
    |-----------------------------
    */
    public static function user(array $with = []): ?User
    {
        $id = self::id();

        if (!$id) {
            return null;
        }

        return User::with($with)->find($id);
    }
}