<?php

namespace App\Support\Enums;

enum UserPanelEnum: string
{
    case ADMIN = 'admin';
    case USER  = 'user';

    /*
    |--------------------------------------------------------------------------
    | Label
    |--------------------------------------------------------------------------
    */
    
    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::USER  => 'User',
        };
    }

    /*
    |--------------------------------------------------------------------------
    | Options
    |--------------------------------------------------------------------------
    */

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn(self $case) => [
                $case->value => $case->label(),
            ])
            ->toArray();
    }

    /*
    |--------------------------------------------------------------------------
    | Options Except
    |--------------------------------------------------------------------------
    */

    public static function optionsExcept(self $panel): array
    {
        return collect(self::cases())
            ->reject(fn(self $case) => $case === $panel)
            ->mapWithKeys(fn(self $case) => [
                $case->value => $case->label(),
            ])
            ->toArray();
    }
}
