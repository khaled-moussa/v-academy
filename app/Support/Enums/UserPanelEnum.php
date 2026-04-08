<?php

namespace App\Support\Enums;

enum UserPanelEnum: string
{
    case ADMIN = 'admin';
    case USER = 'user';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN  => 'Admin',
            self::USER   => 'User',
        };
    }

    public static function options(): array
    {
        return array_combine(
            array_column(self::cases(), 'value'),
            array_map(fn($case) => $case->label(), self::cases())
        );
    }
    
    public static function optionsExcept(UserPanelEnum $panel): array
    {
        $cases = array_filter(
            self::cases(),
            fn($case) => $case->value != $panel->value
        );

        return array_combine(
            array_column($cases, 'value'),
            array_map(fn($case) => $case->label(), $cases)
        );
    }
}
