<?php

namespace App\Domain\Subscription\Actions;

use App\Domain\Subscription\Models\States\SubscriptionStates\SubscriptionApprovedState;
use App\Domain\Subscription\Models\States\SubscriptionStates\SubscriptionRejectedState;
use App\Domain\Subscription\Models\Subscription;
use Carbon\Carbon;

class UpdateSubscriptionStateAction
{
    /*
    |----------------------------------------------------------------------
    | Execute
    |----------------------------------------------------------------------
    */

    public function execute(Subscription $subscription, string $state, bool $isAdminCreated = false): void
    {
        $wasApproved = $subscription->isApproved();

        $subscription->getSubscriptionState()->transitionTo($state);

        $this->handleApprovedState(
            subscription: $subscription,
            state: $state,
            wasApproved: $wasApproved,
            isAdminCreated: $isAdminCreated,
        );

        $this->handleRejectedState(
            subscription: $subscription,
            state: $state,
        );
    }

    /*
    |----------------------------------------------------------------------
    | Handle Approved State
    |----------------------------------------------------------------------
    */

    private function handleApprovedState(Subscription $subscription, string $state, bool $wasApproved,  bool $isAdminCreated): void
    {
        if ($wasApproved || $state !== SubscriptionApprovedState::value()) {
            return;
        }

        if ($isAdminCreated) {
            $this->activateAdminCreated($subscription);
            return;
        }

        $this->activateSubscription($subscription);
    }

    private function activateSubscription(Subscription $subscription): void
    {
        $now = Carbon::now();

        $subscription->update([
            'is_active'       => true,
            'next_renewal_at' => $now->copy()->addMonth()->addDay(),
            'expire_at'       => $now->copy()->addMonth()->endOfDay(),
        ]);
    }

    private function activateAdminCreated(Subscription $subscription): void
    {
        $subscription->update([
            'is_active' => true,
        ]);
    }

    /*
    |----------------------------------------------------------------------
    | Handle Rejected State
    |----------------------------------------------------------------------
    */

    private function handleRejectedState(Subscription $subscription, string $state): void
    {
        if ($state !== SubscriptionRejectedState::value()) {
            return;
        }

        $subscription->update([
            'is_active'       => false,
            'is_current'      => false,
            'next_renewal_at' => null,
            'expire_at'       => null,
        ]);
    }
}
