<?php

namespace App\Domain\NutrationPlan\Models;

use App\App\Web\Resources\NutrationPlans\NutrationPlanResource;
use App\Domain\NutrationPlan\Models\Builders\NutrationPlanQueryBuilder;
use App\Domain\NutrationPlan\Models\Concerns\HasNutrationPlanRelation;
use App\Support\Traits\HasFormattedTimestamps;
use App\Support\Traits\HasUuid;
use Spatie\ModelStates\HasStates;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\UseResource;
use Carbon\Carbon;

#[UseResource(NutrationPlanResource::class)]
class NutrationPlan extends Model
{
    use HasStates;
    use HasUuid;
    use HasFormattedTimestamps;
    use HasNutrationPlanRelation;

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    protected $guarded = [];

    /*
    |--------------------------------------------------------------------------
    | Custom Query Builder
    |--------------------------------------------------------------------------
    */

    public function newEloquentBuilder($query): NutrationPlanQueryBuilder
    {
        return new NutrationPlanQueryBuilder($query);
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

    public function getMeal(): ?string
    {
        return $this->meal;
    }

    public function getSaturday(): string
    {
        return $this->saturday;
    }

    public function getSunday(): string
    {
        return $this->sunday;
    }

    public function getMonday(): string
    {
        return $this->monday;
    }

    public function getTuesday(): string
    {
        return $this->tuesday;
    }
    public function getWednesday(): string
    {
        return $this->wednesday;
    }

    public function getThursday(): string
    {
        return $this->thursday;
    }

    public function getFriday(): string
    {
        return $this->friday;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at;
    }
}
