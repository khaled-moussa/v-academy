<?php

namespace App\Filament\Panels\Admin\Resources\Users\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;

class SubscriptionsRelationManager extends RelationManager
{
    protected static string $relationship = 'subscriptions';

    // protected static ?string $relatedResource = SubscriptionResource::class;
}
