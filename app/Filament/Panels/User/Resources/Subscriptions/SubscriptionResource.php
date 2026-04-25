<?php

namespace App\Filament\Panels\User\Resources\Subscriptions;

use App\Domain\Subscription\Models\Subscription;
use App\Filament\Panels\User\Resources\Subscriptions\Pages\ListSubscriptions;
use App\Filament\Panels\User\Resources\Subscriptions\Schemas\SubscriptionInfolist;
use App\Filament\Panels\User\Resources\Subscriptions\Tables\SubscriptionsTable;
use App\Support\Context\AuthContext;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use BackedEnum;
use Illuminate\Database\Eloquent\Builder;

class SubscriptionResource extends Resource
{
    /* 
    |-----------------------------------------------------------------
    | Resource Configuration
    |-----------------------------------------------------------------
    */

    protected static ?string $model = Subscription::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClock;

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'name';

    /* 
    |-----------------------------------------------------------------
    | Eloquent Query 
    |-----------------------------------------------------------------
    */

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->latest()
            ->whereUserId(AuthContext::id());
    }

    /* 
    |-----------------------------------------------------------------
    | Navigation Labels
    |-----------------------------------------------------------------
    */

    public static function getNavigationLabel(): string
    {
        return 'Subscriptions';
    }

    public static function getModelLabel(): string
    {
        return 'Subscription';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Subscriptions';
    }

    /* 
    |-----------------------------------------------------------------
    | Form & Infolist & Table
    |-----------------------------------------------------------------
    */
    public static function infolist(Schema $schema): Schema
    {
        return SubscriptionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SubscriptionsTable::configure($table);
    }

    /* 
    |------------------------------------------------------------------
    | Relations
    |------------------------------------------------------------------
    */

    public static function getRelations(): array
    {
        return [];
    }

    /* 
    |-----------------------------------------------------------------
    | Pages
    |-----------------------------------------------------------------
    */

    public static function getPages(): array
    {
        return [
            'index' => ListSubscriptions::route('/'),
        ];
    }
}
