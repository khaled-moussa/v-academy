<?php

namespace App\Filament\Panels\User\Resources\Subscriptions\Tables;

use App\Filament\Components\Button\GroupedActionsButton;
use App\Filament\Components\Filter\DateRangeFilter;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
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
            |-----------------------------------------------------------------
            | Columns
            |-----------------------------------------------------------------
            */

            ->columns([

                /*
                |-------------------------------
                | Plan Information
                |--------------------------------
                */

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
                    ->badge()
                    ->color(fn($state) => $state->filamentColor())
                    ->formatStateUsing(fn($state) => $state->label()),

                /*
                |-------------------------------
                | States
                |--------------------------------
                */

                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),

                /*
                |-------------------------------
                | Dates
                |--------------------------------
                */

                TextColumn::make('next_renewal_at')
                    ->label('Next Renewal')
                    ->date()
                    ->placeholder('No expire date yet'),

                TextColumn::make('expire_at')
                    ->label('Expires At')
                    ->date()
                    ->placeholder('No expire date yet'),

            ])

            /* 
            |-----------------------------------------------------------------
            | Table Options
            |-----------------------------------------------------------------
            */

            ->deferLoading()
            ->stackedOnMobile()
            ->searchable(false)

            /*
            |------------------------------------------------------------------
            | Grouping
            |------------------------------------------------------------------
            */

            ->groups([
                Group::make('is_active')
                    ->label('Active')
                    ->getTitleFromRecordUsing(fn($state) => $state ? 'Active' : 'Inactive'),

                Group::make('is_expired')
                    ->label('Expired')
                    ->getTitleFromRecordUsing(fn($state) => $state ? 'Expired' : 'Not Expired'),

                Group::make('created_at_formatted')
                    ->label('Subscribed At')
                    ->date(),
            ])
            ->collapsedGroupsByDefault()

            /*
            |------------------------------------------------------------------
            | Filters
            |------------------------------------------------------------------
            */

            ->filters([
                DateRangeFilter::make()
            ])

            ->filtersFormWidth(Width::Large)

            /*
            |------------------------------------------------------------------
            | Record Actions
            |------------------------------------------------------------------
            */

            ->recordActions(GroupedActionsButton::actions(
                canDelete: false,
                canEdit: false
            ));
    }
}
