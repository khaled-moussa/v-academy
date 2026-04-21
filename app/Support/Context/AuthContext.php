<?php

namespace App\Support\Context;

use App\Domain\Auth\Actions\LogoutUserAction;
use App\Domain\User\Actions\ResolveCurrentUserAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuthContext
{
    private static ?Model $cachedUser = null;
    private static mixed $cachedSettings = null;

    /*
    |------------------------------------------------------------
    | Resolver
    |------------------------------------------------------------
    */

    private static function resolveUser(): ?Model
    {
        return self::$cachedUser
            ??= app(ResolveCurrentUserAction::class)->execute();
    }

    private static function resolveSettings(): mixed
    {
        return self::$cachedSettings
            ??= app('userSetting');
    }

    private static function clearCache(): void
    {
        self::$cachedUser = null;
        self::$cachedSettings = null;
    }

    /*
    |------------------------------------------------------------
    | Auth State
    |------------------------------------------------------------
    */

    public static function check(): bool
    {
        return Auth::check();
    }

    public static function guest(): bool
    {
        return ! self::check();
    }

    public static function logout(): void
    {
        app(LogoutUserAction::class)->execute();

        self::clearCache();
    }

    /*
    |------------------------------------------------------------
    | User
    |------------------------------------------------------------
    */

    public static function user(): ?Model
    {
        return self::resolveUser();
    }

    public static function id(): ?int
    {
        return self::resolveUser()?->getKey();
    }

    /*
    |------------------------------------------------------------
    | User State
    |------------------------------------------------------------
    */

    public static function isActive(): bool
    {
        return self::resolveUser()?->isActive() ?? false;
    }

    public static function hasActiveSubscription(): bool
    {
        return self::resolveUser()?->hasActiveSubscription() ?? false;
    }

    /*
    |------------------------------------------------------------
    | Permissions
    |------------------------------------------------------------
    */

    public static function can(string $permission, mixed $record = null): bool
    {
        return self::resolveUser()?->can($permission, $record) ?? false;
    }

    /*
    |------------------------------------------------------------
    | Settings
    |------------------------------------------------------------
    */

    public static function setting(string $key, mixed $default = null): mixed
    {
        return data_get(self::resolveSettings(), $key, $default);
    }

    public static function settings(): array
    {
        return self::resolveSettings()?->toArray() ?? [];
    }
}
