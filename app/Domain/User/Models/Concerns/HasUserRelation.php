<?php

namespace App\Domain\User\Models\Concerns;

use App\Domain\NutrationPlan\Models\NutrationPlan;
use App\Domain\Subscription\Models\Subscription;
use App\Domain\TrainingSession\Models\Pivots\TrainingSessionJoin;
use App\Domain\TrainingSession\Models\TrainingSession;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasUserRelation
{
    /*
    |------------------------------------------------------------------
    | Core Relations
    |------------------------------------------------------------------
    */

    public function nutrationPlans(): HasMany
    {
        return $this->hasMany(NutrationPlan::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function trainingSessionJoins(): HasMany
    {
        return $this->hasMany(TrainingSessionJoin::class);
    }

    public function trainingSessions(): BelongsToMany
    {
        return $this->belongsToMany(TrainingSession::class, 'training_session_joins')
            ->using(TrainingSessionJoin::class)
            ->withTimestamps();
    }

    /*
    |------------------------------------------------------------------
    | Subscription Scopes (Relations)
    |------------------------------------------------------------------
    */

    public function currentSubscription(): HasOne
    {
        return $this->hasOne(Subscription::class)
            ->current()
            ->latestOfMany();
    }

    public function activeSubscription(): HasOne
    {
        return $this->hasOne(Subscription::class)
            ->active()
            ->latestOfMany();
    }

    public function inActiveSubscriptions(): HasMany
    {
        return $this->subscriptions()
            ->inactive()
            ->latest();
    }

    public function expiredSubscriptions(): HasMany
    {
        return $this->subscriptions()
            ->expired()
            ->latest();
    }
}