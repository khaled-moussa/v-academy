<?php

namespace App\Domain\Plan\Models\Concerns;

use App\Domain\Subscription\Models\Subscription;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasPlanRelation
{

    /*
    |--------------------------------------------------------------------------
    | Core Relations
    |--------------------------------------------------------------------------
    */

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}
