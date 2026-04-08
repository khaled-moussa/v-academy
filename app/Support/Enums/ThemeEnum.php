<?php

namespace App\Support\Enums;

enum ThemeEnum: string
{
    case LIGHT = 'light';
    case DARK = 'dark';
    case SYSTEM = 'system';

    public function label(): string
    {
        return match ($this) {
            self::LIGHT  => 'Light',
            self::DARK   => 'Dark',
            self::SYSTEM => 'System',
        };
    }

    public static function options(): array
    {
        return array_combine(
            array_column(self::cases(), 'value'),
            array_map(fn($case) => $case->label(), self::cases())
        );
    }
}
