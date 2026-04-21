<?php

namespace App\Support\Services\Setting;

use App\Domain\Setting\GeneralSetting\Actions\GetGeneralSettingAction;

class SettingService
{
    public static function boot(): void
    {
        self::generalSetting();
    }

    public static function generalSetting(): void
    {
        app()->bind('generalSetting', fn() => app(GetGeneralSettingAction::class)->execute());
    }
}
