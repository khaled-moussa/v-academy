<?php

use Illuminate\Support\Facades\Schedule;
use App\Domain\Subscription\Jobs\ProcessExpiredSubscriptionsJob;

/*
|--------------------------------------------------------------------------
| Queue & Background Jobs
|--------------------------------------------------------------------------
*/

/**
 * Queue worker — runs every minute
 */

Schedule::command('queue:work --stop-when-empty --tries=3')
    ->everyThirtySeconds()
    ->withoutOverlapping();

/**
 * Handle expired subscriptions processing
 */
Schedule::job(new ProcessExpiredSubscriptionsJob())
    ->everyMinute()
    ->onOneServer()
    ->withoutOverlapping();

/*
|--------------------------------------------------------------------------
| System Maintenance & Optimization
|--------------------------------------------------------------------------
*/

/**
 * Clear compiled caches (config, routes, views)
 */
Schedule::command('optimize:clear')
    ->dailyAt('03:00');

/**
 * Rebuild application caches for performance
 */
Schedule::command('optimize')
    ->dailyAt('03:05');
