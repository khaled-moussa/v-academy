<?php

namespace App\Domain\TrainingSession\Models\SessionStates;

use Filament\Support\Colors\Color;

class SessionAvailableState extends SessionStates
{
    public static function value(): string
    {
        return static::class;
    }
    
    public static function label(): string
    {
        return 'Available';
    }

    public static function filamentColor(): array
    {
        return Color::Green;
    }

    public static function filamentColorClass(): string
    {
        return 'success';
    }
}
