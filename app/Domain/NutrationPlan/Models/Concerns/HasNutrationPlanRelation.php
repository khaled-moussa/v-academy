<?php

namespace App\Domain\NutrationPlan\Models\Concerns;

use App\Domain\User\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasNutrationPlanRelation
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
}
