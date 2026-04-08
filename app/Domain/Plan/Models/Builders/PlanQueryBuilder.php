<?php

namespace App\Domain\Plan\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class PlanQueryBuilder extends Builder
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

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function active(): self
    {
        return $this->whereIsActive(true);
    }
}
