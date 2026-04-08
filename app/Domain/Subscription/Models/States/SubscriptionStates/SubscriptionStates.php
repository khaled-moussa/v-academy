<?php

namespace   App\Domain\Subscription\Models\States\SubscriptionStates;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class SubscriptionStates extends State
{
    abstract public static function value(): string;
    abstract public static function label(): string;
    abstract public static function filamentColor(): array;

    public static function config(): StateConfig
    {
        return parent::config()
            ->default(SubscriptionPendingState::class)
            ->allowAllTransitions();
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public static function options(): array
    {
        return collect(static::all())
            ->mapWithKeys(fn($stateClass) => [
                $stateClass::value() => $stateClass::label(),
            ])
            ->toArray();
    }
}
