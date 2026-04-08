<?php

namespace App\Support\Services\User;

use App\Domain\Setting\GeneralSetting\Actions\GetGeneralSettingAction;
use App\Domain\Subscription\Actions\GetCurrentUserSubscriptionAction;
use App\Support\Context\UserContext;

class UserService
{
    public static function boot(): void
    {
        self::userSubscribtion();
        self::userSetting();
    }

    public static function userSubscribtion(): void
    {
        app()->bind('userSubscription', fn() => app(GetCurrentUserSubscriptionAction::class)->execute(UserContext::user())->toResource());
    }

    public static function userSetting(): void
    {

        app()->bind('generalSetting', fn() => app(GetGeneralSettingAction::class)->execute()->toResource());
    }
}
