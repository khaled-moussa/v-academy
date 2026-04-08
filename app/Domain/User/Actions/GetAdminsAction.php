<?php

namespace App\Domain\User\Actions;

use App\Domain\User\Models\User;
use Illuminate\Support\Collection;

class GetAdminsAction
{
    public function execute(array $with = []): Collection
    {
        return User::query()
            ->whereIsActive()
            ->whereAdminPanel()
            ->with($with)
            ->get();
    }

    public function count(?string $startDate = null, ?string $endDate = null): int
    {
        return User::query()
            ->whereIsActive()
            ->whereAdminPanel()
            ->when($startDate, fn($q) => $q->where('created_at', '>=', $startDate))
            ->when($endDate,   fn($q) => $q->where('created_at', '<=', $endDate))
            ->count();
    }

    public function options(): array
    {
        return $this->execute()
            ->mapWithKeys(fn($user) => [
                $user->getId() => $user->getFullName(),
            ])
            ->toArray();
    }
}
