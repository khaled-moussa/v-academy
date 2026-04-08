<?php

namespace App\Domain\Subscription\Models;

use App\App\Web\Resources\Subscriptions\SubscriptionResource;
use App\Domain\Subscription\Enums\PaymentMethodEnum;
use App\Domain\Subscription\Models\Builders\SubscriptionQueryBuilder;
use App\Domain\Subscription\Models\Concerns\HasSubscriptionRelation;
use App\Domain\Subscription\Models\States\SubscriptionStates\SubscriptionApprovedState;
use App\Domain\Subscription\Models\States\SubscriptionStates\SubscriptionPendingState;
use App\Domain\Subscription\Models\States\SubscriptionStates\SubscriptionStates;
use App\Support\Traits\HasUuid;
use Spatie\ModelStates\HasStates;
use Illuminate\Database\Eloquent\Attributes\UseResource;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

#[UseResource(SubscriptionResource::class)]
class Subscription extends Model
{
    use HasStates;
    use HasUuid;
    use HasSubscriptionRelation;

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    protected $guarded = [];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_method' => PaymentMethodEnum::class,
        'subscription_state' => SubscriptionStates::class,
        'is_active' => 'boolean',
        'next_renewal_at' => 'datetime: d M Y, h:i A',
        'expire_at' => 'datetime: d M Y, h:i A',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Custom Query Builder
    |--------------------------------------------------------------------------
    */

    public function newEloquentBuilder($query): SubscriptionQueryBuilder
    {
        return new SubscriptionQueryBuilder($query);
    }

    /*
    |--------------------------------------------------------------------------
    | Getters
    |--------------------------------------------------------------------------
    */

    public function getId(): int
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function getPaymentMethod(): PaymentMethodEnum
    {
        return $this->payment_method;
    }

    public function getTotalSessions(): int
    {
        return $this->total_sessions;
    }

    public function getUsedSessions(): int
    {
        return $this->used_sessions;
    }

    public function getSubscriptionState(): SubscriptionStates
    {
        return $this->subscription_state;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getPlanId(): int
    {
        return $this->plan_id;
    }

    public function getNexRenewalAt(): ?Carbon
    {
        return $this->next_renewal_at;
    }

    public function getExpireAt(): ?Carbon
    {
        return $this->expire_at;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at;
    }

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */
    public function isPending(): bool
    {
        return $this->getSubscriptionState() == SubscriptionPendingState::value();
    }

    public function isApproved(): bool
    {
        return $this->getSubscriptionState() == SubscriptionApprovedState::value();
    }

    public function isExpired(): bool
    {
        return $this->expire_at?->isPast() ?? false;
    }

    public function isCurrent(): bool
    {
        return $this->is_current;
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }
}
