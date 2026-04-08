<?php

namespace App\Domain\User\Models\Builders;

use App\Support\Enums\UserPanelEnum;
use Illuminate\Database\Eloquent\Builder;

class UserQueryBuilder extends Builder
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

    public function whereEmail(string $email): self
    {
        return $this->where('email', $email);
    }

    public function whereSocialId(string $socialId,): self
    {
        return $this->where('social_id', $socialId);
    }

    public function wherePanel(UserPanelEnum $panel): static
    {
        return $this->where('panel', $panel->value);
    }

    public function whereInPanels(array $panels): static
    {
        return $this->whereIn(
            'panel',
            array_map(fn(UserPanelEnum $panel) => $panel->value, $panels)
        );
    }

    public function whereAdminPanel(): static
    {
        return $this->wherePanel(UserPanelEnum::ADMIN);
    }

    public function whereUserPanel(): static
    {
        return $this->wherePanel(UserPanelEnum::USER);
    }

    /*
    |--------------------------------------------------------------------------
    | Status
    |--------------------------------------------------------------------------
    */

    public function whereIsActive(bool $active = true): static
    {
        return $this->where('is_active', $active);
    }

    /*
    |--------------------------------------------------------------------------
    | Exclusions
    |--------------------------------------------------------------------------
    */

    public function whereNotUser(int $userId): static
    {
        return $this->whereKeyNot($userId);
    }
}