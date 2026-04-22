<?php

namespace App\Filament\Panels\Admin\Resources\Plans\Schemas;

use App\Domain\Plan\Models\Plan;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;

class PlanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make()
                    ->schema([

                        /*
                        |-----------------------------------
                        | Plan Information
                        |-----------------------------------
                        */

                        Section::make('Plan Information')
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Plan Name')
                                    ->afterLabel([
                                        TextEntry::make('is_popular')
                                            ->hiddenLabel()
                                            ->badge()
                                            ->state('Pouplar')
                                            ->hidden(fn($record) => !$record?->isPopular()),
                                    ])
                                    ->weight('bold'),


                                TextEntry::make('no_of_sessions')
                                    ->label('Number of Sessions')
                                    ->badge(),

                                TextEntry::make('price')
                                    ->label('Price')
                                    ->formatStateUsing(fn($record) => static::formatPrice($record))
                                    ->html(),

                                TextEntry::make('discount')
                                    ->label('Discount')
                                    ->suffix('%'),
                            ])
                            ->columns(2)
                            ->compact()
                            ->secondary(),

                        /*
                        |-----------------------------------
                        | Plan Details
                        |-----------------------------------
                        */

                        Section::make('Plan Includes')
                            ->schema([
                                TextEntry::make('includes')
                                    ->hiddenLabel()
                                    ->formatStateUsing(
                                        fn($state) => is_array($state)
                                            ? implode(', ', $state)
                                            : $state
                                    )
                                    ->bulleted(),
                            ])
                            ->compact()
                            ->secondary()
                            ->collapsible(),

                        /*
                        |-----------------------------------
                        | Meta
                        |-----------------------------------
                        */

                        Section::make('Meta')
                            ->schema([
                                IconEntry::make('is_active')
                                    ->label('Active')
                                    ->boolean(),

                                TextEntry::make('created_at_formatted')
                                    ->label('Created At')
                                    ->badge()
                                    ->color(Color::Gray)
                                    ->dateTime(),
                            ])
                            ->columns(2)
                            ->compact()
                            ->secondary(),
                    ])
                    ->columnSpanFull(),
            ]);
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
