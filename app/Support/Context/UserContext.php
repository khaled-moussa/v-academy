<?php

namespace App\Support\Context;

use App\Domain\User\Actions\ResolveCurrentUserAction;
use App\Domain\User\Models\User;

class UserContext
{
    private static function resolve(): User
    {
        return app(ResolveCurrentUserAction::class)->execute();
    }

    public static function user(): User
    {
        return self::resolve();
    }

    public static function id(): int
    {
        return self::resolve()->getId();
    }

    public static function userCan(string $permission, $record): bool
    {
        return self::resolve()->can($permission, $record) ?? false;
    }

    public static function hasActiveSubscription(): bool
    {
        return self::user()->hasActiveSubscription();
    }
}
