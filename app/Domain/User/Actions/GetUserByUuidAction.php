<?php

namespace App\Domain\User\Actions;

use App\Domain\User\Models\User;

class GetUserByUuidAction
{
    /**
     * Get specific user by uuid.
     */
    public function execute(string $userUuid): ?User
    {
        return User::query()
            ->whereUuid($userUuid)
            ->first();
    }
}
