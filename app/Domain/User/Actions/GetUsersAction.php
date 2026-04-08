<?php

namespace App\Domain\User\Actions;

use App\Domain\User\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class GetUsersAction
{
    public function execute(array $with = [], ?string $startDate = null, ?string $endDate = null): Collection
    {
        return $this->query($startDate, $endDate)
            ->with($with)
            ->get();
    }

    public function count(?string $startDate = null, ?string $endDate = null): int
    {
        return $this->query($startDate, $endDate)
            ->count();
    }

    private function query(?string $startDate = null, ?string $endDate = null): Builder
    {
        return User::query()
            ->whereIsActive()
            ->whereUserPanel()
            ->when($startDate, fn($q) => $q->where('created_at', '>=', $startDate))
            ->when($endDate,   fn($q) => $q->where('created_at', '<=', $endDate));
    }
}
