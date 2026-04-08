<?php

namespace App\Domain\Auth\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyEmailRequestNotification extends VerifyEmail implements ShouldQueue
{
    use Queueable;
}
