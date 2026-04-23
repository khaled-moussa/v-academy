<?php

namespace App\Support\Enums;

enum ThemeEnum: string
{
    case LIGHT = 'light';
    case DARK = 'dark';
    case SYSTEM = 'system';

    /*
    |--------------------------------------------------------------------------
    | Label
    |--------------------------------------------------------------------------
    */

    public function label(): string
    {
        return match ($this) {
            self::LIGHT  => 'Light',
            self::DARK   => 'Dark',
            self::SYSTEM => 'System',
        };
    }

    /*
    |--------------------------------------------------------------------------
    | Options (for Select fields)
    |--------------------------------------------------------------------------
    */
    
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $case) => [
                $case->value => $case->label(),
            ])
            ->toArray();
    }
}