<?php

namespace App\Domain\Setting\GeneralSetting\Models;

use App\App\Web\Resources\Settings\GeneralSettingResource;
use App\Domain\Setting\GeneralSetting\Models\Builders\GeneralSettingQueryBuilder;
use App\Support\Traits\HasUuid;
use Illuminate\Database\Eloquent\Attributes\UseResource;
use Illuminate\Database\Eloquent\Model;

#[UseResource(GeneralSettingResource::class)]
class GeneralSetting extends Model
{
    use HasUuid;

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    protected $guarded = [];

    protected $casts = [
        'phones' => 'array',
        'user_can_create_session' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Custom Query Builder
    |--------------------------------------------------------------------------
    */

    public function newEloquentBuilder($query): GeneralSettingQueryBuilder
    {
        return new GeneralSettingQueryBuilder($query);
    }

    /*
    |-----------------------------------------------------------------------
    | Getters
    |-----------------------------------------------------------------------
    */

    public function getId(): int
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getSiteName(): string
    {
        return $this->site_name;
    }

    public function getDescription(): ?array
    {
        return $this->description ? json_decode($this->description, true) : null;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getLocationUrl(): ?string
    {
        return $this->location_url;
    }

    public function getSupportEmail(): string
    {
        return $this->support_email;
    }

    public function getPhones(): ?array
    {
        return $this->phones;
    }

    public function getMaxCapacity(): int
    {
        return $this->max_capacity;
    }

    public function canUserCreateSession(): bool
    {
        return (bool) $this->user_can_create_session;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }
}
