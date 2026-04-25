<?php

namespace App\Domain\Subscription\Jobs;

use App\Domain\Subscription\Actions\GetExpiredSubscriptionsAction;
use Illuminate\Bus\Queueable;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class ProcessExpiredSubscriptionsJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /*
    |----------------------------------------------------------------------
    | Queue Settings
    |----------------------------------------------------------------------
    */

    public int $tries = 3;

    public int $timeout = 120;

    /*
    |----------------------------------------------------------------------
    | Handle
    |----------------------------------------------------------------------
    */

    public function handle(): void
    {
        app(GetExpiredSubscriptionsAction::class)
            ->query()
            ->chunkById(200, function ($subscriptions): void {

                $jobs = [];

                foreach ($subscriptions as $subscription) {
                    $jobs[] = new ExpireSubscriptionJob($subscription->id);
                }

                if (empty($jobs)) {
                    return;
                }

                Bus::batch($jobs)
                    ->name('Expire Subscriptions')
                    ->allowFailures()
                    ->then(function (Batch $batch): void {
                        logger()->info('Expire subscriptions batch completed.', [
                            'batch_id' => $batch->id,
                            'total_jobs' => $batch->totalJobs,
                        ]);
                    })
                    ->catch(function (Batch $batch, Throwable $exception): void {
                        logger()->error('Expire subscriptions batch failed.', [
                            'batch_id' => $batch->id,
                            'error' => $exception->getMessage(),
                        ]);
                    })
                    ->dispatch();
            });
    }
}