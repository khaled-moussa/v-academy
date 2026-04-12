<?php

namespace App\Providers\Filament;

use App\Domain\Auth\Middlewares\RedirectIfAuthenticatedToDashboard;
use App\Domain\Auth\Middlewares\SetUserTimezoneMiddleware;
use App\Filament\Pages\CustomDashboard;
use App\Filament\Pages\CustomEditProfile;
use App\Filament\Widgets\CustomAccountWidget;
use Filament\Http\Middleware\Authenticate;
use Filament\Enums\ThemeMode;
use Filament\Facades\Filament;
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

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel

            /* 
            |-------------------------------
            | Panel Basics
            |--------------------------------
            */
            ->id('admin')
            ->path('admin')
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
            // ->brandLogo(asset('images/logo.svg'))
            // ->favicon(asset('images/favicon.png'))
            ->font('Poppins')
            ->defaultThemeMode(ThemeMode::System)

            ->sidebarCollapsibleOnDesktop()
            ->collapsedSidebarWidth('9rem')

            ->globalSearch(false)

            /* 
            |-------------------------------
            | Discovery
            |--------------------------------
            */
            ->discoverResources(in: app_path('Filament/Panels/Admin/Resources'), for: 'App\Filament\Panels\Admin\Resources')
            ->discoverWidgets(in: app_path('Filament/Panels/Admin/Widgets'), for: 'App\Filament\Panels\Admin\Widgets')
            ->discoverPages(in: app_path('Filament/Panels/Admin/Pages'), for: 'App\Filament\Panels\Admin\Pages')

            /* 
            |-------------------------------
            | Pages & Widgets
            |--------------------------------
            */
            ->pages([
                CustomDashboard::class,
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
