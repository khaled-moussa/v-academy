<?php

namespace App\Domain\User\Actions;

use App\Domain\User\Models\User;

class UpdateUserSocialIdAction
{
    /**
     * Update an scoialite id and provider.
     */
    public function execute(User $user, string $socialId, string $provider): void
    {
        $user->update(['social_id' => $socialId, 'provider' => $provider]);
    }
}
