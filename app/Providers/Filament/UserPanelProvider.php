<?php

namespace App\Providers\Filament;

use App\Domain\Auth\Middlewares\EnsureUserIsActive;
use App\Filament\Pages\CustomEditProfile;
use App\Filament\Widgets\CustomAccountWidget;
use Filament\Facades\Filament;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class UserPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel

            /* 
            |-------------------------------
            | Panel Basics
            |--------------------------------
            */

            ->id('user')
            ->path('user')
            ->login(fn() => redirect(to: Filament::getPanel('auth')->getLoginUrl()))
            // ->emailVerification()
            // ->emailChangeVerification()


            ->profile(CustomEditProfile::class)

            /* 
            |-------------------------------
            | Appearance
            |--------------------------------
            */
            ->brandName(config('company-info.site'))
            ->font('Poppins')

            ->sidebarCollapsibleOnDesktop()
            ->sidebarWidth('20rem')
            ->collapsedSidebarWidth('9rem')

            ->globalSearch(false)

            /* 
            |-------------------------------
            | Discovery
            |--------------------------------
            */

            ->discoverResources(in: app_path('Filament/Panels/User/Resources'), for: 'App\Filament\Panels\User\Resources')
            ->discoverWidgets(in: app_path('Filament/Panels/User/Widgets'), for: 'App\Filament\Panels\User\Widgets')
            ->discoverPages(in: app_path('Filament/Panels/User/Pages'), for: 'App\Filament\Panels\User\Pages')

            /* 
            |-------------------------------
            | Pages & Widgets
            |--------------------------------
            */

            ->pages([
                Dashboard::class,
            ])

            ->widgets([
                CustomAccountWidget::class,
            ])

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
                EnsureUserIsActive::class,
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
