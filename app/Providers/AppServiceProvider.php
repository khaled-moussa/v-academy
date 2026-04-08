<?php

namespace App\Providers;

use App\App\Web\Responses\CustomLoginResponse;
use App\App\Web\Responses\CustomRegisterResponse;
use App\Support\Services\Filament\FilamentService;
use App\Support\Services\User\UserService;
use Filament\Auth\Http\Responses\LoginResponse as BaseLoginResponse;
use Filament\Auth\Http\Responses\RegistrationResponse as BaseRegisterResponse;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /* 
    |-------------------------------
    | Container Bindings
    |-------------------------------
    */
    public array $singletons = [
        BaseLoginResponse::class        => CustomLoginResponse::class,
        BaseRegisterResponse::class     => CustomRegisterResponse::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(
        FilamentService $filamentService,
        UserService $userService,
    ): void {
        $filamentService->boot();
        $userService->boot();
    }
}