<?php

namespace App\Domain\Setting\GeneralSetting\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class GeneralSettingQueryBuilder extends Builder
{
    /*
    |--------------------------------------------------------------------------
    | Key Filters
    |--------------------------------------------------------------------------
    */

    public function whereUuid(string $uuid): static
    {
        return $this->where('uuid', $uuid);
    }
}