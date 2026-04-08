<?php

namespace App\Domain\Subscription\Actions;

use App\Domain\Subscription\Models\States\SubscriptionStates\SubscriptionApprovedState;
use App\Domain\Subscription\Models\States\SubscriptionStates\SubscriptionRejectedState;
use App\Domain\Subscription\Models\Subscription;
use Carbon\Carbon;

class UpdateSubscriptionStateAction
{
    public function execute(Subscription $subscription, string $state): void
    {
        $wasApproved = $subscription->isApproved();

        $subscription->getSubscriptionState()->transitionTo($state);

        /*
        |------------------------------------------------------------------
        | Handle Approved
        |------------------------------------------------------------------
        */
        if (!$wasApproved && $state === SubscriptionApprovedState::value()) {
            $this->handleApproved($subscription);
        }

        /*
        |------------------------------------------------------------------
        | Handle Rejected
        |------------------------------------------------------------------
        */
        if ($state === SubscriptionRejectedState::value()) {
            $this->handleRejected($subscription);
        }
    }

    /*
    |----------------------------------------------------------------------
    | Approved 
    |----------------------------------------------------------------------
    */
    private function handleApproved(Subscription $subscription): void
    {
        $subscription->update([
            'is_active'        => true,
            'next_renewal_at'  => Carbon::now()->addMonth()->addDay(),
            'expire_at'        => Carbon::now()->addMonth()->endOfDay(),
        ]);
    }

    /*
    |----------------------------------------------------------------------
    | Rejected 
    |----------------------------------------------------------------------
    */
    private function handleRejected(Subscription $subscription): void
    {
        $subscription->update([
            'is_active'        => false,
            'is_current'       => false,
            'next_renewal_at'  => null,
            'expire_at'        => null,
        ]);
    }
}
