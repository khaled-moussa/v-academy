<?php

namespace App\Support\Enums;

use Filament\Support\Colors\Color;

enum GenderEnum: string
{
    case MALE = 'male';
    case FEMALE = 'female';

    public function label(): string
    {
        return match ($this) {
            self::MALE => 'Male',
            self::FEMALE => 'Female',
        };
    }

    public function filamentColor(): array
    {
        return match ($this) {
            self::MALE => Color::Blue,
            self::FEMALE => Color::Pink,
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
