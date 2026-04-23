<?php

namespace App\Support\Services\View;

use App\Support\Context\AuthContext;
use App\Support\Context\GeneralSettingContext;
use Illuminate\Support\Facades\View;

class ViewService
{
    public static function boot(): void
    {
        self::shareAuthUser();
        self::shareGeneralSetting();
    }

    private static function shareGeneralSetting()
    {
        View::composer(
            [
                'pages.landing.*',
                'filament.auth.*'
            ],
            function ($view) {
                $view->with([
                    'settings' => GeneralSettingContext::toResource()
                ]);
            }
        );
    }

    private static function shareAuthUser()
    {
        View::composer(
            [
                'pages.landing.*',
            ],
            function ($view) {
                $view->with([
                    'user' => AuthContext::toResource()
                ]);
            }
        );
    }
}
