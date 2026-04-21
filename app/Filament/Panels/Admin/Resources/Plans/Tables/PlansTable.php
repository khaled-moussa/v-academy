<?php

namespace App\Filament\Panels\Admin\Resources\Plans\Tables;

use App\Filament\Components\Button\GroupedActionsButton;
use App\Filament\Components\Filter\DateRangeFilter;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;

class PlansTable
{
    public static function configure(Table $table): Table
    {
        return $table

            /*
            |------------------------------------------------------------------
            | Header
            |------------------------------------------------------------------
            */

            ->heading('Plans')
            ->description('Manage your subscription plans here.')

            /*
            |------------------------------------------------------------------
            | Columns
            |------------------------------------------------------------------
            */

            ->columns([

                TextColumn::make('name')
                    ->label('Plan Name')
                    ->weight(FontWeight::Bold)
                    ->searchable(),


                TextColumn::make('no_of_sessions')
                    ->label('Total Sessions')
                    ->badge(),

                /*
                |-----------------------------
                | Secondary Info
                |-----------------------------
                */

                TextColumn::make('price')
                    ->label('Price')
                    ->color(Color::Gray)
                    ->money('EGP', locale: 'nl'),

                /*
                |-----------------------------------
                | Timestamp
                |-----------------------------------
                */
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->badge()
                    ->icon(Heroicon::OutlinedClock)
                    ->formatStateUsing(fn($record) => $record->getCreatedAt()),

                /*
                |-----------------------------------
                | States
                |-----------------------------------
                */

                ToggleColumn::make('is_active')
                    ->label('Active'),

                ToggleColumn::make('is_popular')
                    ->label('Popular'),

            ])

            /*
            |------------------------------------------------------------------
            | Table Options
            |------------------------------------------------------------------
            */

            ->deferLoading()
            ->searchPlaceholder('Seacrch, Plan name')

            /*
            |------------------------------------------------------------------
            | Grouping
            |------------------------------------------------------------------
            */

            ->groups([
                Group::make('is_active')
                    ->label('Active Status')
                    ->titlePrefixedWithLabel(false)
                    ->getTitleFromRecordUsing(
                        fn($state) => $state ? 'Active' : 'Inactive'
                    ),

                Group::make('created_at')
                    ->date(),
            ])
            ->collapsedGroupsByDefault()

            /*
            |------------------------------------------------------------------
            | Filters
            |------------------------------------------------------------------
            */

            ->filters([
                DateRangeFilter::make('session_date')
                    ->label('Session Date Range'),
            ])
            ->filtersFormWidth(Width::Large)

            /*
            |------------------------------------------------------------------
            | Actions
            |------------------------------------------------------------------
            */

            ->recordActions(GroupedActionsButton::actions());
    }
}
