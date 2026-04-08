<?php

namespace App\Domain\Subscription\Dtos;

class SubscriptionDto
{
    public function __construct(
        public readonly string $amount,
        public readonly string $paymentMethod,
        public readonly int $totalSessions,
        public readonly int $planId,
        public readonly int $userId
    ) {}

    /*
    |--------------------------------------------------------------------------
    | Export — To Array
    |--------------------------------------------------------------------------
    */

    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'payment_method'  => $this->paymentMethod,
            'total_sessions'  => $this->totalSessions,
            'plan_id'         => $this->planId,
            'user_id'         => $this->userId,
        ];
    }
}
