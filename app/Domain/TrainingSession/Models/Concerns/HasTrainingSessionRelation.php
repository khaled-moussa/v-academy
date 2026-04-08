<?php

namespace App\Domain\TrainingSession\Models\Concerns;

use App\Domain\TrainingSession\Models\Pivots\TrainingSessionJoin;
use App\Domain\User\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasTrainingSessionRelation
{

    /*
    |--------------------------------------------------------------------------
    | Core Relations
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_created_session_id');
    }

    public function userBooking()
    {
        return $this->belongsToMany(User::class, 'training_session_joins')
            ->using(TrainingSessionJoin::class)
            ->withPivot('id', 'uuid', 'attendance')
            ->withTimestamps();
    }
}
