<?php

namespace App\Domain\TrainingSession\Models\SessionStates;

use Filament\Support\Colors\Color;

class SessionFullState extends SessionStates
{
    public static function value(): string
    {
        return static::class;
    }

    public static function label(): string
    {
        return 'Full Booked';
    }

    public static function filamentColor(): array
    {
        return Color::Blue;
    }

    public static function filamentColorClass(): string
    {
        return 'blue';
    }
}
