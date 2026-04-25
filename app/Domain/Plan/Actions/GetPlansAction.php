<?php

namespace App\Domain\Plan\Actions;

use App\Domain\Plan\Models\Plan;
use Illuminate\Support\Collection;

class GetPlansAction
{
    public function execute(): Collection
    {
        return Plan::query()
            ->active()
            ->get();
    }

    public function options(): array
    {
        return $this->execute()
            ->mapWithKeys(fn($plan) => [
                $plan->getId() => $plan->getName()
            ])
            ->toArray();
    }
}
