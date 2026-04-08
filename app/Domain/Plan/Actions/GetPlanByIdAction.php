<?php

namespace App\Domain\Plan\Actions;

use App\Domain\Plan\Models\Plan;

class GetPlanByIdAction
{
    public function execute(int $planId): ?Plan
    {
        return Plan::query()
            ->active()
            ->find($planId);
    }
}
