<?php

namespace App\Domain\TrainingSession\Models\SessionStates;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class SessionStates extends State
{
    abstract public static function value(): string;
    abstract public static function label(): string;
    abstract public static function filamentColor(): array;
    abstract public static function filamentColorClass(): string;

    public static function config(): StateConfig
    {
        return parent::config()
            ->default(SessionAvailableState::class)
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