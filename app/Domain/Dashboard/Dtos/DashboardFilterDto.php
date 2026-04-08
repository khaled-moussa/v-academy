<?php

namespace App\Domain\Dashboard\Dtos;

class DashboardFilterDto
{
    public function __construct(
        public readonly ?string $startDate = null,
        public readonly ?string $endDate   = null,
    ) {}

    /*
    |--------------------------------------------------------------------------
    | Import — From Array
    |--------------------------------------------------------------------------
    */

    public static function fromFilters(?array $filters = []): self
    {
        return new self(
            startDate: $filters['daterange']['start'] ?? null,
            endDate: $filters['daterange']['end'] ?? null,
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Export — To Array
    |--------------------------------------------------------------------------
    */

    public function toArray(): array
    {
        return [
            'daterange' => [
                'start' => $this->startDate,
                'end'   => $this->endDate,
            ],
        ];
    }
}
