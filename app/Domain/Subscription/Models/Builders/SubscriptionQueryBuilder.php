<?php

namespace App\Domain\Subscription\Models\Builders;

use App\Domain\Subscription\Models\States\SubscriptionStates\SubscriptionApprovedState;
use App\Domain\Subscription\Models\States\SubscriptionStates\SubscriptionPendingState;
use App\Domain\Subscription\Models\States\SubscriptionStates\SubscriptionRejectedState;
use Illuminate\Database\Eloquent\Builder;

class SubscriptionQueryBuilder extends Builder
{
    /*
    |------------------------------------------------------------------
    | Identifiers
    |------------------------------------------------------------------
    */

    public function whereUuid(string $uuid): self
    {
        return $this->where('uuid', $uuid);
    }

    public function whereUserId(int $userId): self
    {
        return $this->where('user_id', $userId);
    }

    /*
    |------------------------------------------------------------------
    | Status Filters
    |------------------------------------------------------------------
    */

    public function active(): self
    {
        return $this->where('is_active', true);
    }

    public function inactive(): self
    {
        return $this->where('is_active', false);
    }

    public function current(): self
    {
        return $this->where('is_current', true);
    }

    /*
    |------------------------------------------------------------------
    | State Filters
    |------------------------------------------------------------------
    */

    public function state(string $state): self
    {
        return $this->where('subscription_state', $state);
    }

    public function pending(): self
    {
        return $this->state(SubscriptionPendingState::class);
    }

    public function approved(): self
    {
        return $this->state(SubscriptionApprovedState::class);
    }

    public function rejected(): self
    {
        return $this->state(SubscriptionRejectedState::class);
    }

    /*
    |------------------------------------------------------------------
    | Date Filters
    |------------------------------------------------------------------
    */

    public function expired(): self
    {
        return $this->whereNotNull('expire_at')
            ->where('expire_at', '<', now());
    }

    public function notExpired(): self
    {
        return $this->whereNull('expire_at')
            ->orWhere('expire_at', '>=', now());
    }

    public function expireProcessingNull(): self
    {
        return $this->whereNull('expired_processing_at');
    }
}
