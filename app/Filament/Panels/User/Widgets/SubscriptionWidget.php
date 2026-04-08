<?php

namespace App\Filament\Panels\User\Widgets;

use App\Support\Context\UserContext;
use Filament\Widgets\Widget;

class SubscriptionWidget extends Widget
{
    /* -------------------------------
    | Configuration
    |------------------------------- */

    protected string $view = 'filament.panels.user.widgets.subscription-widget';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 1;

    /* -------------------------------
    | Data
    |------------------------------- */

    public function getViewData(): array
    {
        $user = UserContext::user();

        $subscription = $user->activeSubscription;
        $plan         = $subscription?->plan;

        return [
            'user'                 => $user,
            'plan'                 => $plan?->toResource(),
            'subscription'         => $subscription,
            'isSubscribed'         => $user->hasActiveSubscription(),
            'isSubscribedPending'  => $user->hasPendingSubscription(),
        ];
    }
}