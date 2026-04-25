<?php

namespace App\Domain\Subscription\Actions;

use App\Domain\Subscription\Models\Subscription;

class UpdateExpireSubscriptionAction
{
    /*
    |----------------------------------------------------------------------
    | Execute
    |----------------------------------------------------------------------
    */

    public function execute(Subscription|int $subscription): void
    {
        $subscriptionId = $subscription instanceof Subscription
            ? $subscription->id
            : $subscription;

        /*
        |------------------------------------------------------------------
        | Atomic Safe Update
        |------------------------------------------------------------------
        |
        | Prevent:
        | - duplicate processing
        | - race conditions
        | - unnecessary model loading
        |
        */

        Subscription::query()
            ->whereKey($subscriptionId)
            ->active()
            ->current()
            ->expireProcessingNull()
            ->update([
                'is_active' => false,
                'is_current' => false,
                'expired_processing_at' => now(),
            ]);
    }
}
