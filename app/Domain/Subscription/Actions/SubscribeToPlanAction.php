<?php

namespace App\Domain\Subscription\Actions;

use App\Domain\Subscription\Dtos\SubscriptionDto;
use App\Domain\Subscription\Models\Subscription;

class SubscribeToPlanAction
{
    public function execute(SubscriptionDto $dto): Subscription
    {
        $subscription = Subscription::create($dto->toArray());

        if (! is_null($dto->imagePath)) {
            $subscription
                ->addMedia(storage_path('app/public/' . $dto->imagePath))
                ->usingFileName(basename($dto->imagePath))
                ->toMediaCollection('payment_proofs');
        }

        return $subscription;
    }
}
