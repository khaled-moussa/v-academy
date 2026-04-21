<?php

namespace App\Support\Services;

use App\Support\Services\Filament\FilamentService;
use App\Support\Services\Setting\SettingService;
use App\Support\Services\User\UserService;
use App\Support\Services\View\ViewService;
use App\Support\Services\Vite\ViteService;

class AppServiceBootstrap
{
    public static function boot(): void
    {
        ViewService::boot();
        ViteService::boot();
        FilamentService::boot();
        SettingService::boot();
        UserService::boot();
    }
}
