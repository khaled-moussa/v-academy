<?php

namespace App\Domain\Dashboard\Traits;

use Carbon\Carbon;

trait HasFilterByDateTrait
{
    public ?Carbon $startDate = null;
    public ?Carbon $endDate = null;

    /* -------------------------------
    | Resolve start and end dates
    |------------------------------- */
    protected function getDateRange(): void
    {
        $startDate = $this->pageFilters['daterange']['start'] ?? null;
        $endDate   = $this->pageFilters['daterange']['end'] ?? null;

        $this->startDate = $startDate ? Carbon::parse($startDate)->startOfDay() : null;
        $this->endDate   = $endDate ? Carbon::parse($endDate)->endOfDay() : null;
    }
}