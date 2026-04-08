<?php

namespace App\Domain\Subscription\Actions;

use App\Domain\Subscription\Models\Subscription;
use App\Domain\User\Models\User;

class GetCurrentUserSubscriptionAction
{
    public function execute(User $user): ?Subscription
    {
        return $user->currentSubscription;
    }

    public function exists(User $user): bool
    {
        return $user->currentSubscription()->exists();
    }

    public function activeSubscription(User $user): bool
    {
        return $user->activeSubscription()->exists();
    }
}
