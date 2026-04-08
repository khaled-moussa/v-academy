<?php

namespace App\Domain\TrainingSession\Models;

use App\Domain\SocialAccount\Models\Concerns\HasSocialAccountRelation;
use App\Domain\TrainingSession\Models\Builders\TrainingSessionQueryBuilder;
use App\Domain\TrainingSession\Models\Concerns\HasTrainingSessionRelation;
use App\Domain\TrainingSession\Models\SessionStates\SessionStates;
use App\Support\Traits\HasUuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\ModelStates\HasStates;

class TrainingSession extends Model
{
    use HasUuid;
    use HasStates;
    use HasTrainingSessionRelation;

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    protected $guarded = [];

    protected $casts = [
        'session_state' => SessionStates::class,
        'is_admin_created' => 'boolean',
        'is_active' => 'boolean',
        'session_date' => 'date',
        'session_time' => 'datetime:H:i',
    ];

    /*
    |--------------------------------------------------------------------------
    | Custom Query Builder
    |--------------------------------------------------------------------------
    */

    public function newEloquentBuilder($query): TrainingSessionQueryBuilder
    {
        return new TrainingSessionQueryBuilder($query);
    }

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getCapacity(): int
    {
        return $this->capacity;
    }

    public function getBooking(): int
    {
        return (int) $this->booking;
    }

    public function getSessionState(): SessionStates
    {
        return $this->session_state;
    }

    public function getSessionDate(): Carbon
    {
        return $this->session_date;
    }

    public function getSessionTime(): ?string
    {
        return optional($this->session_time)?->format('h:i A');
    }

    public function getUserCreatedSessionId(): int
    {
        return $this->user_created_session_id;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at;
    }

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    public function isAdminCreated(): bool
    {
        return $this->is_admin_created;
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }
}
