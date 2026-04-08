<?php

namespace App\Domain\User\Actions;

use App\Domain\User\Models\User;

class GetUserByIdAction
{
    /**
     * Get specific user by id.
     */
    public function execute(string $userUuid): ?User
    {
        return User::query()
            ->whereUuid($userUuid)
            ->first();
    }
}
