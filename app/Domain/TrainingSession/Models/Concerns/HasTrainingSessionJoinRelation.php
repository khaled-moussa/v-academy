<?php

namespace App\Domain\TrainingSession\Models\Concerns;

use App\Domain\TrainingSession\Models\TrainingSession;
use App\Domain\User\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasTrainingSessionJoinRelation
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

    public function trainingSession(): BelongsTo
    {
        return $this->belongsTo(TrainingSession::class);
    }
}
