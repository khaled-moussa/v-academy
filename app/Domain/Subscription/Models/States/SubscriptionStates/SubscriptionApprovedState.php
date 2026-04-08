<?php

namespace App\Domain\Subscription\Models\States\SubscriptionStates;

use Filament\Support\Colors\Color;

class SubscriptionApprovedState extends SubscriptionStates
{
    public static function value(): string
    {
        return static::class;
    }
    public static function label(): string
    {
        return 'Approved';
    }

    public static function filamentColor(): array
    {
        return Color::Green;
    }
}
