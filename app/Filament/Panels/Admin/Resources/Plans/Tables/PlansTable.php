<?php

namespace App\Filament\Panels\Admin\Resources\Plans\Tables;

use App\Domain\Plan\Models\Plan;
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

                TextColumn::make('price')
                    ->label('Price')
                    ->formatStateUsing(fn($record) => static::formatPrice($record))
                    ->html(),

                TextColumn::make('discount')
                    ->label('Discount')
                    ->color(Color::Gray)
                    ->suffix('%'),

                /*
                |-----------------------------------
                | Timestamp
                |-----------------------------------
                */

                TextColumn::make('created_at_formatted')
                    ->label('Created At')
                    ->badge(),

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
                    ->getTitleFromRecordUsing(fn($state) => $state ? 'Active' : 'Inactive'),

                Group::make('created_at_formatted')
                    ->label('Created At')
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
            | Record Actions
            |------------------------------------------------------------------
            */

            ->recordActions(GroupedActionsButton::actions());
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    private static function formatPrice(Plan $plan): string
    {
        $price = $plan->getPrice();
        $priceDiscount = $plan->getPriceDiscount();
        $discount = $plan->getDiscount();

        if ($discount > 0) {
            return "
            <div class='flex flex-col'>
                <span style='text-decoration-line: line-through; color:gray'>
                    {$price} EGP
                </span>

                <span>
                    {$priceDiscount} EGP
                </span>
            </div>
        ";
        }

        return "<span>{$price} EGP</span>";
    }
}
