<?php

namespace App\Filament\Components\Notification;

use Filament\Notifications\Notification;

class CustomNotification
{
    /*
    |--------------------------------------------------------------------------
    | Main Builder
    |--------------------------------------------------------------------------
    */

    public static function make(
        string $title,
        ?string $description = null,
        string $type = 'success', // success | danger | warning | info
        int $duration = 5000,
        bool $persistent = false,
        array $actions = []
    ): Notification {
        $notification = Notification::make()
            ->title($title)
            ->body($description)
            ->duration($duration);

        /*
        |-------------------------------
        | Type Handling
        |-------------------------------
        */

        match ($type) {
            'success' => $notification->success(),
            'danger'  => $notification->danger(),
            'warning' => $notification->warning(),
            'info'    => $notification->info(),
            default   => $notification->success(),
        };

        /*
        |-------------------------------
        | Persistent
        |-------------------------------
        */

        if ($persistent) {
            $notification->persistent();
        }

        /*
        |-------------------------------
        | Actions
        |-------------------------------
        */

        if (!empty($actions)) {
            $notification->actions($actions);
        }

        return $notification->send();
    }

    /*
    |--------------------------------------------------------------------------
    | Shortcuts (Cleaner Usage)
    |--------------------------------------------------------------------------
    */

    public static function success(string $title, ?string $description = null): Notification
    {
        return self::make($title, $description, 'success');
    }

    public static function error(string $title, ?string $description = null): Notification
    {
        return self::make($title, $description, 'danger');
    }

    public static function warning(string $title, ?string $description = null): Notification
    {
        return self::make($title, $description, 'warning');
    }

    public static function info(string $title, ?string $description = null): Notification
    {
        return self::make($title, $description, 'info');
    }
}