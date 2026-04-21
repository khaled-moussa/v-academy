<?php

namespace App\Support\Services\View;

use App\Support\Context\GeneralSettingContext;
use Illuminate\Support\Facades\View;

class ViewService
{
    public static function boot(): void
    {
        self::shareGeneralSetting();
    }

    private static function shareGeneralSetting()
    {
        View::composer(
            'pages.landing.*',
            function ($view) {
                $view->with([
                    'generalSetting' => GeneralSettingContext::toArray()
                ]);
            }
        );
    }
}
