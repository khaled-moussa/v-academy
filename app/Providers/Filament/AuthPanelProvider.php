<?php

namespace App\Providers\Filament;

use App\Domain\Auth\Middlewares\RedirectIfAuthenticatedToDashboard;
use App\Filament\Pages\CustomLogin;
use App\Filament\Pages\CustomRegister;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AuthPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel

            /* 
            |-------------------------------
            | Panel Basics
            |--------------------------------
            */
            ->default()
            ->id('auth')
            ->path('auth')
            ->login(CustomLogin::class)
            ->registration(CustomRegister::class)
            ->passwordReset()
            ->emailVerification()

            /* 
            |-------------------------------
            | Appearance
            |--------------------------------
            */
            ->brandName(fn() => view('filament.auth.brand-name'))
            ->font('Poppins')

            /* 
            |-------------------------------
            | Middleware
            |--------------------------------
            */
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                RedirectIfAuthenticatedToDashboard::class
            ])

            ->authMiddleware([
                Authenticate::class,
            ])

            /* 
            |-------------------------------
            | Plugins
            |--------------------------------
            */
            ->plugins([]);
    }
}
