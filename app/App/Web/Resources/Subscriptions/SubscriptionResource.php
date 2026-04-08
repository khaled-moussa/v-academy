<?php

namespace App\App\Web\Resources\Subscriptions;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                   => $this->getId(),
            'uuid'                 => $this->getUuid(),

            'amount'               => $this->getAmount(),
            'payment_method'       => $this->getPaymentMethod(),
            'subscription_state'   => $this->getSubscriptionState(),

            'user_id'              => $this->getUserId(),
            'plan_id'              => $this->getPlanId(),

            'next_renewal_at'      => $this->getNexRenewalAt()?->toISOString(),
            'expire_at'            => $this->getExpireAt()?->toISOString(),

            'created_at'           => $this->getCreatedAt(),
            'updated_at'           => $this->getUpdatedAt(),
        ];
    }
}
