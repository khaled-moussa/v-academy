<?php

namespace App\Domain\TrainingSession\Models\Builders;

use App\Domain\TrainingSession\Models\SessionStates\SessionAvailableState;
use Illuminate\Database\Eloquent\Builder;

class TrainingSessionQueryBuilder extends Builder
{
    /*
    |--------------------------------------------------------------------------
    | Keys Filters
    |--------------------------------------------------------------------------
    */

    public function whereUuid(string $uuid): self
    {
        return $this->where('uuid', $uuid);
    }

    public function whereIsActive(bool $isActive): self
    {
        return $this->where('is_active', $isActive);
    }

    public function whereUserId(int $userId): self
    {
        return $this->where('user_id', $userId);
    }

    public function whenUserBookig(?int $userId): self
    {
        return $this->when($userId, fn($q) => $q->whereHas('userBooking', fn($q) => $q->where('user_id', $userId)));
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function available(): self
    {
        return $this->where('session_state', SessionAvailableState::value());
    }

    public function past(): self
    {
        return $this->whereNotNull('session_date')
            ->where('session_date', '<', now());
    }

    public function notPast(): self
    {
        return $this->whereNotNull('session_date')
            ->where('session_date', '>=', now());
    }
}
