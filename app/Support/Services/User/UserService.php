<?php

namespace App\Support\Services\User;

use App\Domain\Subscription\Actions\GetCurrentUserSubscriptionAction;
use App\Support\Context\AuthContext;

class UserService
{
    public static function boot(): void
    {
        self::userSubscribtion();
    }


    public static function userSubscribtion(): void
    {
        app()->bind('userSubscription', fn() => app(GetCurrentUserSubscriptionAction::class)->execute(AuthContext::user())->toResource());
    }
}
