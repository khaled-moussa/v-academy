<?php

namespace App\Domain\TrainingSession\Actions;

use App\Domain\TrainingSession\Models\TrainingSession;
use App\Domain\User\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class GetSessionsAction
{
    /* 
    |-------------------------------
    | Fetch All Sessions
    |------------------------------- 
    */
    public function execute(
        array $with = [],
        ?User $user = null,
        ?string $startDate = null,
        ?string $endDate = null
    ): Collection {
        return $this->query($user, $startDate, $endDate)
            ->with($with)
            ->get();
    }

    /* 
    |-------------------------------
    | Upcoming Sessions For User (Booked)
    |------------------------------- 
    */
    public function upcomingUserSessions(
        ?User $user = null,
        ?string $startDate = null,
        ?string $endDate = null
    ) {

        return $this->query(null, $startDate, $endDate)
            ->when(
                $user,
                fn(Builder $q) =>
                $q->whenUserBookig($user->getId())
            )
            ->whereBetween('session_date', [$startDate, $endDate])
            ->orderBy('session_date');
    }

    /* 
    |-------------------------------
    | Count Sessions
    |------------------------------- 
    */
    public function count(
        ?string $startDate = null,
        ?string $endDate = null
    ): int {
        return $this->query(null, $startDate, $endDate)->count();
    }

    /* 
    |-------------------------------
    | Base Query
    |------------------------------- 
    */
    private function query(
        ?User $user = null,
        ?string $startDate = null,
        ?string $endDate = null
    ): Builder {
        return TrainingSession::query()
            ->when(
                $user,
                fn(Builder $q) =>
                $q->whereUserId($user->getId())
            )
            ->when(
                $startDate,
                fn(Builder $q) =>
                $q->whereDate('session_date', '>=', $startDate)
            )
            ->when(
                $endDate,
                fn(Builder $q) =>
                $q->whereDate('session_date', '<=', $endDate)
            );
    }
}
