<?php

namespace App\Support\Services\Filament;

use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;

class FilamentService
{
    public static function boot(): void
    {
        self::registerBrandColor();
        self::registerNamedColors();
    }

    private static function registerBrandColor(): void
    {
        FilamentColor::register([
            'primary' => [
                50  => 'oklch(0.97 0 0)',
                100 => 'oklch(0.92 0 0)',
                200 => 'oklch(0.85 0 0)',
                300 => 'oklch(0.70 0 0)',
                400 => 'oklch(0.55 0 0)',
                500 => 'oklch(0.40 0 0)',
                600 => 'oklch(0.30 0 0)',
                700 => 'oklch(0.20 0 0)',
                800 => 'oklch(0.12 0 0)',
                900 => 'oklch(0.06 0 0)',
                950 => 'oklch(0.02 0 0)',
            ],
        ]);
    }

    private static function registerNamedColors(): void
    {
        FilamentColor::register([
            'indigo' => Color::Indigo,
        ]);
    }
}
