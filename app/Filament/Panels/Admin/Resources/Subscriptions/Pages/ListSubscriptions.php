<?php

namespace App\Filament\Panels\Admin\Resources\Subscriptions\Pages;

use App\Filament\Panels\Admin\Resources\Subscriptions\SubscriptionResource;
use Filament\Resources\Pages\ListRecords;

class ListSubscriptions extends ListRecords
{
    protected static string $resource = SubscriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
