<?php

namespace App\Domain\Plan\Models;

use App\App\Web\Resources\Plans\PlanResource;
use App\Domain\Plan\Models\Builders\PlanQueryBuilder;
use App\Domain\Plan\Models\Concerns\HasPlanRelation;
use App\Support\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\UseResource;

#[UseResource(PlanResource::class)]
class Plan extends Model
{
    use HasUuid;
    use HasPlanRelation;

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    protected $guarded = [];

    protected $casts = [
        'price' => 'float',
        'includes' => 'array',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Custom Query Builder
    |--------------------------------------------------------------------------
    */

    public function newEloquentBuilder($query): PlanQueryBuilder
    {
        return new PlanQueryBuilder($query);
    }

    /*
    |--------------------------------------------------------------------------
    | Getters
    |--------------------------------------------------------------------------
    */

    public function getId(): int
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getNoOfSession(): int
    {
        return $this->no_of_sessions;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getIncludes(): ?array
    {
        return $this->includes;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at;
    }

    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    */

    public function isActive(): bool
    {
        return $this->is_active;
    }
}
