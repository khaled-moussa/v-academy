<?php

namespace App\Domain\Subscription\Models\Concerns;

use App\Domain\Plan\Models\Plan;
use App\Domain\User\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasSubscriptionRelation
{

    /*
    |--------------------------------------------------------------------------
    | Core Relations
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }
}
