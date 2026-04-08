<?php

namespace App\Domain\TrainingSession\Actions;

use App\Domain\TrainingSession\Models\SessionStates\SessionAvailableState;
use App\Domain\TrainingSession\Models\TrainingSession;
use App\Domain\User\Models\User;

class CancelSessionAction
{
    public function execute(User $user, TrainingSession $session): void
    {
        $session->userBooking()->detach($user);

        if ($session->getBooking() > 0) {
            $session->decrement('booking');
        }

        if ($session->getBooking() < $session->getCapacity()) {
            $session->getSessionState()->transitionTo(SessionAvailableState::class);
        }
    }
}