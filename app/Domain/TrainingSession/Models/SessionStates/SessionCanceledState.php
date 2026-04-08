<?php

namespace App\Domain\TrainingSession\Models\SessionStates;

use Filament\Support\Colors\Color;

class SessionCanceledState extends SessionStates
{
    public static function value(): string
    {
        return static::class;
    }

    public static function label(): string
    {
        return 'Canceled';
    }

    public static function filamentColor(): array
    {
        return Color::Red;
    }

    public static function filamentColorClass(): string
    {
        return 'danger';
    }
}
