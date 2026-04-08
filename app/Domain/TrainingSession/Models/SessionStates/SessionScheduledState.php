<?php

namespace App\Domain\TrainingSession\Models\SessionStates;

use Filament\Support\Colors\Color;

class SessionScheduledState extends SessionStates
{
    public static function value(): string
    {
        return static::class;
    }

    public static function label(): string
    {
        return 'Scheduled';
    }

    public static function filamentColor(): array
    {
        return Color::Orange;
    }

    public static function filamentColorClass(): string
    {
        return 'warning';
    }
}
