<?php

namespace App\Domain\TrainingSession\Actions;

use App\Domain\TrainingSession\Models\TrainingSession;
use App\Domain\User\Models\User;

class CheckIsUserBookedSession
{
    public function execute(User $user, TrainingSession $trainingSession): bool
    {
        return $trainingSession->userBooking()
            ->whereUserId($user->getId())
            ->exists();
    }
}
