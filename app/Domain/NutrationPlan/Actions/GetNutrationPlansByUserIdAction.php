<?php

namespace App\Domain\NutrationPlan\Actions;

use App\Domain\NutrationPlan\Models\NutrationPlan;
use App\Domain\User\Models\User;
use Illuminate\Support\Collection;

class GetNutrationPlansByUserIdAction
{
    /* 
    |-------------------------------
    | Fetch All Sessions
    |------------------------------- 
    */
    public function execute(User $user): Collection
    {
        return NutrationPlan::query()
            ->whereUserId($user->getId())
            ->get();
    }
}
