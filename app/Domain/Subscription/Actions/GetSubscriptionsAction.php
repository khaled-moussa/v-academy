<?php

namespace App\Domain\Subscription\Actions;

use App\Domain\Subscription\Models\Subscription;
use App\Domain\User\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class GetSubscriptionsAction
{
    /* 
    |-------------------------------
    | Fetch All Subscriptions
    |-------------------------------
    */
    public function execute(array $with = [], User $user, ?string $startDate = null, ?string $endDate = null, ?string $state = null): Collection
    {
        return $this->query($user, $startDate, $endDate, $state)
            ->with($with)
            ->get();
    }

    /* 
    |-------------------------------
    | Count Subscriptions
    |-------------------------------
    */
    public function count(?string $startDate = null, ?string $endDate = null, ?string $state = null): int
    {
        return $this->query(null, $startDate, $endDate, $state)->count();
    }

    /* 
    |-------------------------------
    | Base Query
    |-------------------------------
    */
    private function query(?User $user = null, ?string $startDate = null, ?string $endDate = null, $state): Builder
    {
        return Subscription::query()
            ->when($startDate, fn(Builder $q) => $q->where('created_at', '>=', $startDate))
            ->when($endDate, fn(Builder $q) => $q->where('created_at', '<=', $endDate))
            ->when($state, fn($q) => $q->whereSubscriptionState($state));
    }
}
