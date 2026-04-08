<?php

namespace App\Domain\TrainingSession\Actions;

use App\Domain\TrainingSession\Models\SessionStates\SessionFullState;
use App\Domain\TrainingSession\Models\TrainingSession;
use App\Domain\User\Models\User;

class BookSessionAction
{
    public function execute(User $user, TrainingSession $session): void
    {
        $session->userBooking()->syncWithoutDetaching($user);

        if ($session->getBooking() < $session->getCapacity()) {
            $session->increment('booking');
        }

        if ($session->getBooking() >= $session->getCapacity()) {
            $session->getSessionState()->transitionTo(SessionFullState::class);
        }
    }
}