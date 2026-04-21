<?php

namespace App\Support\Services\Vite;

use Illuminate\Support\Facades\Vite;

class ViteService
{
    public static function boot(): void
    {
        self::viteMacros();
    }

    private static function viteMacros(): void
    {
        // Default image
        Vite::macro(
            'image',
            fn(string $asset) =>
            Vite::asset("resources/assets/images/{$asset}")
        );

        // Default style path
        Vite::macro(
            'style',
            fn(string $path) =>
            Vite::withEntryPoints("resources/css/pages/{$path}")
        );

        // Default script path
        Vite::macro(
            'script',
            fn(string $path) =>
            Vite::withEntryPoints("resources/js/pages/{$path}")
        );

        // Admin style path
        Vite::macro(
            'adminStyle',
            fn(string $path) =>
            Vite::withEntryPoints("resources/css/pages/panels/admin/{$path}")
        );

        // Admin script path
        Vite::macro(
            'adminScript',
            fn(string $path) =>
            Vite::withEntryPoints("resources/js/pages/panels/admin/{$path}")
        );

        // User style path
        Vite::macro(
            'userStyle',
            fn(string $path) =>
            Vite::withEntryPoints("resources/css/pages/panels/user/{$path}")
        );

        // User script path
        Vite::macro(
            'userScript',
            fn(string $path) =>
            Vite::withEntryPoints("resources/js/pages/panels/user/{$path}")
        );
    }
}
