<?php

namespace App\Domain\Subscription\Actions;

use App\Domain\Subscription\Dtos\SubscriptionDto;
use App\Domain\Subscription\Models\Subscription;

class SubscribeToPlanAction
{
    public function execute(SubscriptionDto $dto): Subscription
    {
        return Subscription::create($dto->toArray());
    }
}
