<?php

namespace App\Domain\Setting\GeneralSetting\Models\Concerns;

use App\Domain\Setting\User\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasGeneralSettingRelation
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
