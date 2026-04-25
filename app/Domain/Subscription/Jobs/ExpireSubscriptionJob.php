<?php

namespace App\Domain\Subscription\Jobs;

use App\Domain\Subscription\Actions\UpdateExpireSubscriptionAction;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExpireSubscriptionJob implements ShouldQueue
{
    use Batchable;
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

    public array $backoff = [10, 30, 60];

    public int $timeout = 60;

    /*
    |----------------------------------------------------------------------
    | Constructor
    |----------------------------------------------------------------------
    */

    public function __construct(
        private readonly int $subscriptionId,
    ) {}

    /*
    |----------------------------------------------------------------------
    | Handle
    |----------------------------------------------------------------------
    */

    public function handle(): void
    {
        app(UpdateExpireSubscriptionAction::class)
            ->execute($this->subscriptionId);
    }

    /*
    |----------------------------------------------------------------------
    | Failure
    |----------------------------------------------------------------------
    */

    public function failed(\Throwable $exception): void
    {
        logger()->error('ExpireSubscriptionJob failed.', [
            'subscription_id' => $this->subscriptionId,
            'error' => $exception->getMessage(),
        ]);
    }
}
