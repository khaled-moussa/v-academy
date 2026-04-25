<?php

use Illuminate\Support\Facades\Schedule;
use App\Domain\Subscription\Jobs\ProcessExpiredSubscriptionsJob;

Schedule::job(new ProcessExpiredSubscriptionsJob())
    ->everyMinute()
    ->withoutOverlapping()
    ->onOneServer();
