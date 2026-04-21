<?php

namespace App\Providers;

use App\App\Web\Responses\CustomLoginResponse;
use App\App\Web\Responses\CustomRegisterResponse;
use App\Support\Services\AppServiceBootstrap;
use Filament\Auth\Http\Responses\LoginResponse as BaseLoginResponse;
use Filament\Auth\Http\Responses\RegistrationResponse as BaseRegisterResponse;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $singletons = [
        BaseLoginResponse::class        => CustomLoginResponse::class,
        BaseRegisterResponse::class     => CustomRegisterResponse::class,
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        AppServiceBootstrap::boot();
    }
}
