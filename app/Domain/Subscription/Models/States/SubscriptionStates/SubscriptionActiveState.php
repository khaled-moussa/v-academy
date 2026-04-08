<?php

namespace App\Domain\Subscription\Models\States\SubscriptionStates;

use Filament\Support\Colors\Color;

class SubscriptionActiveState extends SubscriptionStates
{
    public static function value(): string
    {
        return static::class;
    }

    public static function label(): string
    {
        return 'Active';
    }

    public static function filamentColor(): array
    {
        return Color::Green;
    }
}
