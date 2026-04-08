<?php

namespace App\Domain\User\Actions;

use App\Domain\User\Models\User;

class GetUserByEmailAction
{
    /**
     * Get specific user by uuid.
     */
    public function execute(string $email): ?User
    {
        return User::query()
            ->whereEmail($email)
            ->first();
    }
}
