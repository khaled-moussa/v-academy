<?php

namespace App\Domain\Subscription\Dtos;

class SubscriptionDto
{
    public function __construct(
        public readonly string $amount,
        public readonly string $paymentMethod,
        public readonly int $totalSessions,
        public readonly int $planId,
        public readonly int $userId,
        public readonly bool $isAdminCreated = false,
        public readonly ?string $imagePath = null,
        public readonly ?int $usedSessions = null,
        public readonly ?string $nextRenewalDate = null,
        public readonly ?string $expireDate = null,
    ) {}

    /*
    |--------------------------------------------------------------------------
    | Export — To Array
    |--------------------------------------------------------------------------
    */

    public function toArray(): array
    {
        return [
            'amount'           => $this->amount,
            'payment_method'   => $this->paymentMethod,
            'total_sessions'   => $this->totalSessions,
            'used_sessions'    => $this->usedSessions,
            'is_admin_created' => $this->isAdminCreated,
            'plan_id'          => $this->planId,
            'user_id'          => $this->userId,
            'next_renewal_at'  => $this->nextRenewalDate,
            'expire_at'        => $this->expireDate,
        ];
    }
}
