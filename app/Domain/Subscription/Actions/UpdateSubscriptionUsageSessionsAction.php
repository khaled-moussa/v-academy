<?php

namespace App\Domain\Subscription\Actions;

use App\Domain\Subscription\Models\Subscription;

class UpdateSubscriptionUsageSessionsAction
{
    public function execute(Subscription $subscription, bool $attended): void
    {
        if (!$attended) {
            if ($subscription->getUsedSessions() > 0) {
                $subscription->decrement('used_sessions');
            }

            return;
        }

        $subscription->increment('used_sessions');
    }
}
