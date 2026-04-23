<?php

namespace App\Support\Context;

use Illuminate\Database\Eloquent\Model;

class GeneralSettingContext
{
    private static ?Model $cached = null;

    /*
    |------------------------------------------------------------
    | Resolver
    |------------------------------------------------------------
    */

    private static function resolve(): ?Model
    {
        return self::$cached ??= app('generalSetting');
    }

    /*
    |------------------------------------------------------------
    | Access
    |------------------------------------------------------------
    */

    public static function get(string $key, mixed $default = null): mixed
    {
        return data_get(self::resolve(), $key, $default);
    }

    public static function all(): ?Model
    {
        return self::resolve();
    }

    public static function toResource()
    {
        return self::resolve()?->toResource();
    }

    public static function toArray(): array
    {
        return self::resolve()?->toResource()->resolve() ?? [];
    }
}
