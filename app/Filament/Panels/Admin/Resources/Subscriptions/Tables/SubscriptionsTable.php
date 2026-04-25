<?php

namespace App\Filament\Panels\Admin\Resources\Subscriptions\Tables;

use App\Domain\Subscription\Enums\PaymentMethodEnum;
use App\Filament\Components\Button\GroupedActionsButton;
use App\Filament\Components\Filter\DateRangeFilter;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;

class SubscriptionsTable
{
    public static function configure(Table $table): Table
    {
        return $table

            /*
            |------------------------------------------------------------------
            | Header
            |------------------------------------------------------------------
            */

            ->heading('Subscriptions')
            ->description('Manage user subscriptions here.')

            /*
            |------------------------------------------------------------------
            | Columns
            |------------------------------------------------------------------
            */

            ->columns(self::columns())

            /*
            |------------------------------------------------------------------
            | Table Options
            |------------------------------------------------------------------
            */

            ->deferLoading()
            ->stackedOnMobile()
            ->searchable(false)

            /*
            |------------------------------------------------------------------
            | Grouping
            |------------------------------------------------------------------
            */

            ->groups(self::groups())
            ->collapsedGroupsByDefault()

            /*
            |------------------------------------------------------------------
            | Filters
            |------------------------------------------------------------------
            */

            ->filters(self::filters())
            ->filtersFormWidth(Width::Large)

            /*
            |------------------------------------------------------------------
            | Record Actions
            |------------------------------------------------------------------
            */

            ->recordActions(GroupedActionsButton::actions());
    }

    /*
    |--------------------------------------------------------------------------
    | Columns
    |--------------------------------------------------------------------------
    */

    private static function columns(): array
    {
        return [

            TextColumn::make('plan.name')
                ->label('Plan'),

            TextColumn::make('amount')
                ->label('Amount')
                ->money('EGP'),

            TextColumn::make('payment_method')
                ->label('Payment Method')
                ->badge()
                ->color(fn($state) => $state->color())
                ->formatStateUsing(fn($state) => $state->label()),

            TextColumn::make('subscription_state')
                ->label('State')
                ->description(fn($record) => $record->isAdminCreated() ? 'Created by admin' : null)
                ->badge()
                ->color(fn($state) => $state->filamentColor())
                ->formatStateUsing(fn($state) => $state->label()),

            IconColumn::make('is_active')
                ->label('Active')
                ->boolean(),

            TextColumn::make('next_renewal_at')
                ->label('Next Renewal')
                ->date()
                ->placeholder('N/A'),

            TextColumn::make('expire_at')
                ->label('Expires At')
                ->date()
                ->placeholder('N/A')
                ->badge()
                ->color(
                    fn($record) => $record->isExpired()
                        ? Color::Rose
                        : Color::Gray
                )
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Groups
    |--------------------------------------------------------------------------
    */

    private static function groups(): array
    {
        return [
            Group::make('is_active')
                ->label('Active')
                ->titlePrefixedWithLabel(false)
                ->getTitleFromRecordUsing(fn($record) => $record->isActive() ? 'Active' : 'Inactive'),

            Group::make('expire_at')
                ->label('Expired')
                ->titlePrefixedWithLabel(false)
                ->getTitleFromRecordUsing(fn($record) => $record->isExpired() ? 'Expired' : 'Not Expired'),

            Group::make('created_at')
                ->label('Subscribed At')
                ->date(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Filters
    |--------------------------------------------------------------------------
    */

    private static function filters(): array
    {
        return [
            SelectFilter::make('payment_method')
                ->options(PaymentMethodEnum::options())
                ->native(false),

            DateRangeFilter::make(),
        ];
    }
}
