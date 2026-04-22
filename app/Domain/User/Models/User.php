<?php

namespace App\Domain\User\Models;

use App\Domain\User\Models\Builders\UserQueryBuilder;
use App\Domain\User\Models\Concerns\HasUserRelation;
use App\Support\Enums\GenderEnum;
use App\Support\Enums\UserPanelEnum;
use App\Support\Traits\HasFormattedTimestamps;
use App\Support\Traits\HasUuid;
use Carbon\Carbon;
use Filament\Panel;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasName;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser, HasName, HasAvatar
{
    use Notifiable;
    use HasUuid;
    use HasFormattedTimestamps;
    use HasUserRelation;

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    protected $guarded = [];

    protected $appends = [
        'full_name',
        'avatar_url',
        'is_email_verified',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'gender' => GenderEnum::class,
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'created_at' => 'datetime:M d, Y h:i A',
    ];

    /*
    |--------------------------------------------------------------------------
    | Custom Query Builder
    |--------------------------------------------------------------------------
    */

    public function newEloquentBuilder($query): UserQueryBuilder
    {
        return new UserQueryBuilder($query);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function getAvatarUrlAttribute(): string
    {
        $encodedName = urlencode($this->full_name);

        return "https://ui-avatars.com/api/?name={$encodedName}&color=FFFFFF&background=09090b";
    }

    public function getIsEmailVerifiedAttribute(): bool
    {
        return $this->hasVerifiedEmail();
    }

    /*
    |--------------------------------------------------------------------------
    | Panel Access
    |--------------------------------------------------------------------------
    */

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'auth') {
            return true;
        }

        return $this->panel === $panel->getId();
    }

    /*
    |--------------------------------------------------------------------------
    | Filament Customization
    |--------------------------------------------------------------------------
    */

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url;
    }

    public function getFilamentName(): string
    {
        return $this->full_name;
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

    public function getFullName(): ?string
    {
        return $this->full_name;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function getGender(): GenderEnum
    {
        return $this->gender;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function getPanel(): ?string
    {
        return $this->panel;
    }

    public function getProvider(): ?string
    {
        return $this->provider;
    }

    public function getSocialId(): ?string
    {
        return $this->social_id;
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

    public function isAdminPanel(): bool
    {
        return $this->panel === UserPanelEnum::ADMIN->value;
    }

    public function isUserPanel(): bool
    {
        return $this->panel === UserPanelEnum::USER->value;
    }

    public function isActive(): bool
    {
        return (bool) $this->is_active;
    }

    public function hasActiveSubscription(): bool
    {
        return (bool) $this->activeSubscription?->exists();
    }

    public function hasPendingSubscription(): bool
    {
        return (bool) $this->currentSubscription?->isPending();
    }
}
