<?php

namespace App\Filament\Panels\Admin\Resources\Subscriptions\Pages;

use App\Filament\Panels\Admin\Resources\Subscriptions\SubscriptionResource;
use Filament\Resources\Pages\ViewRecord;

class ViewSubscription extends ViewRecord
{
    protected static string $resource = SubscriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
