<?php

namespace App\Domain\NutrationPlan\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class NutrationPlanQueryBuilder extends Builder
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

    public function whereUserId(int $userId): self
    {
        return $this->where('user_id', $userId);
    }
}
