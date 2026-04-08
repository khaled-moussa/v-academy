<?php

namespace App\Filament\Panels\Admin\Resources\Plans\RelationManagers;

use App\Filament\Panels\Admin\Resources\Subscriptions\SubscriptionResource;
use Filament\Resources\RelationManagers\RelationManager;

class SubscriptionsSessionRelationManager extends RelationManager
{
    protected static string $relationship = 'subscriptions';

    protected static ?string $relatedResource = SubscriptionResource::class;
}
