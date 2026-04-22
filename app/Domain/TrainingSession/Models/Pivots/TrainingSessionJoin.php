<?php

namespace App\Domain\TrainingSession\Models\Pivots;

use App\Support\Traits\HasUuid;
use App\Support\Traits\HasFormattedTimestamps;
use App\Domain\TrainingSession\Models\Concerns\HasTrainingSessionJoinRelation;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Carbon\Carbon;

class TrainingSessionJoin extends Pivot
{
    use HasUuid;
    use HasFormattedTimestamps;
    use HasTrainingSessionJoinRelation;

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    protected $table = 'training_session_joins';

    protected $guarded = [];

    protected $casts = [
        'attendance' => 'bool',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Getters
    |--------------------------------------------------------------------------
    */

    public function getId(): int
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getAttendance(): bool
    {
        return $this->attendance;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getTrainingSessionId(): int
    {
        return $this->training_session_id;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at;
    }
}
