<?php

namespace App\Support\Services\Filament;

use App\Filament\Components\Notification\CustomNotification;
use Filament\Facades\Filament;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;

class FilamentService
{
    public static function boot(): void
    {
        self::registerBrandColor();
        self::registerNamedColors();
        self::registerSessionNotifications();
    }

    /*
    |-------------------------------
    | Brand Colors
    |-------------------------------
    */
    private static function registerBrandColor(): void
    {
        FilamentColor::register([
            'primary' => [
                50  => '#fdf8ee',
                100 => '#f7e9b8',
                200 => '#f0d78e',
                300 => '#e6c26a',
                400 => '#d7ad4a',
                500 => '#855e1b', // BASE
                600 => '#a97822',
                700 => '#c3912b',
                800 => '#614515',
                900 => '#3d2c0e',
                950 => '#241a08',
            ],
        ]);
    }

    /*
    |-------------------------------
    | Named Colors
    |-------------------------------
    */
    private static function registerNamedColors(): void
    {
        FilamentColor::register([
            'indigo' => Color::Indigo,
        ]);
    }

    /*
    |-------------------------------
    | Session Notifications
    |-------------------------------
    */
    private static function registerSessionNotifications(): void
    {
        Filament::serving(function () {

            if (session()->has('server_error')) {
                $message = session()->pull('server_error');

                CustomNotification::error(title: __('Server Error'), description: __($message));
            }
        });
    }
}
