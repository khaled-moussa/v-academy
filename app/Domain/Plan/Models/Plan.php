<?php

namespace App\Domain\Plan\Models;

use App\App\Web\Resources\Plans\PlanResource;
use App\Domain\Plan\Models\Builders\PlanQueryBuilder;
use App\Domain\Plan\Models\Concerns\HasPlanRelation;
use App\Support\Traits\HasFormattedTimestamps;
use App\Support\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\UseResource;

#[UseResource(PlanResource::class)]
class Plan extends Model
{
    use HasUuid;
    use HasFormattedTimestamps;
    use HasPlanRelation;

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    protected $guarded = [];

    protected $casts = [
        'price' => 'float',
        'discount' => 'integer',
        'includes' => 'array',
        'is_active' => 'boolean',
        'is_popular' => 'boolean',
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
    |  Attributes
    |--------------------------------------------------------------------------
    */
    public function getPriceDiscountAttribute(): float
    {
        $priceDiscount = $this->price * ($this->discount / 100);
        return $this->price - $priceDiscount;
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

    public function getPriceDiscount(): float
    {
        return $this->price_discount;
    }

    public function getDiscount(): ?int
    {
        return $this->discount;
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

    public function hasDiscount(): bool
    {
        return $this->discount > 0;
    }

    public function isPopular(): bool
    {
        return $this->is_popular;
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }
}
