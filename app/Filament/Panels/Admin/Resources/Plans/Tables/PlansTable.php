<?php

namespace App\Filament\Panels\Admin\Resources\Plans\Tables;

use App\Domain\Plan\Models\Plan;
use App\Filament\Components\Button\GroupedActionsButton;
use App\Filament\Components\Filter\DateRangeFilter;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\Width;
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

            ->columns(self::columns())

            /*
            |------------------------------------------------------------------
            | Table Options
            |------------------------------------------------------------------
            */

            ->deferLoading()
            ->stackedOnMobile()
            ->searchPlaceholder('Search plan name')

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

            TextColumn::make('name')
                ->label('Plan Name')
                ->weight(FontWeight::Bold)
                ->searchable(),

            TextColumn::make('no_of_sessions')
                ->label('Total Sessions')
                ->badge(),

            TextColumn::make('price')
                ->label('Price')
                ->formatStateUsing(
                    fn(Plan $record) => self::formatPrice($record)
                )
                ->html(),

            TextColumn::make('discount')
                ->label('Discount')
                ->color(Color::Gray)
                ->suffix('%'),

            TextColumn::make('created_at_formatted')
                ->label('Created At')
                ->badge(),

            ToggleColumn::make('is_active')
                ->label('Active'),

            ToggleColumn::make('is_popular')
                ->label('Popular'),
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
                ->label('Active Status')
                ->titlePrefixedWithLabel(false)
                ->getTitleFromRecordUsing(fn($record) => $record->isActive() ? 'Active' : 'Inactive'),

            Group::make('created_at')
                ->label('Created At')
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
            DateRangeFilter::make('created_at')
                ->label('Plan Date Range'),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    private static function formatPrice(Plan $plan): string
    {
        $price = $plan->getPrice();
        $discountedPrice = $plan->getPriceDiscount();
        $discount = $plan->getDiscount();

        if ($discount > 0) {
            return "
                <div class='flex flex-col'>
                    <span style='text-decoration-line: line-through; color:gray'>
                        {$price} EGP
                    </span>

                    <span>
                        {$discountedPrice} EGP
                    </span>
                </div>
            ";
        }

        return "<span>{$price} EGP</span>";
    }
}
