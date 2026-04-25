<?php

namespace App\Domain\Subscription\Actions;

use App\Domain\Subscription\Models\Subscription;
use Illuminate\Database\Eloquent\Builder;

class GetExpiredSubscriptionsAction
{
    /*
    |-------------------------------
    | Build Query Only (NOT execute)
    |-------------------------------
    */

    public function query(array $with = []): Builder
    {
        return Subscription::query()
            ->with($with)
            ->active()
            ->expired()
            ->current()
            ->approved()
            ->expireProcessingNull();
    }
}