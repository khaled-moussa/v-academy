<?php

namespace App\Filament\Panels\Admin\Resources\Plans\Schemas;

use App\Domain\Plan\Models\Plan;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\RawJs;

class PlanForm
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
                                TextInput::make('name')
                                    ->label('Plan Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Enter plan name'),

                                TextInput::make('no_of_sessions')
                                    ->label('Number of Sessions')
                                    ->numeric()
                                    ->required()
                                    ->placeholder('Enter number of sessions'),

                                TextInput::make('price')
                                    ->label('Price')
                                    ->belowContent(fn($record) => self::resolvePriceAfterDiscount($record))
                                    ->required()
                                    ->numeric()
                                    ->minValue(1)
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->suffix('EGP'),

                                TextInput::make('discount')
                                    ->label('Discount')
                                    ->required()
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(100)
                                    ->default(0)
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->suffix('%'),

                            ])
                            ->columns(2)
                            ->secondary()
                            ->compact()
                            ->collapsible()
                            ->collapsed(false),

                        /*
                        |-----------------------------------
                        | Plan Details
                        |-----------------------------------
                        */

                        Section::make('Plan Details')
                            ->schema([
                                Repeater::make('includes')
                                    ->label('Includes')
                                    ->simple(
                                        TextInput::make('item')
                                            ->hiddenLabel()
                                            ->required()
                                            ->placeholder('e.g. Diet Plan'),
                                    )
                                    ->addActionLabel('Add Feature')
                                    ->itemLabel(fn(array $state): ?string => $state['item'] ?? null)
                                    ->reorderable()
                                    ->collapsible()
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->secondary()
                            ->compact()
                            ->collapsible()
                            ->collapsed(false),

                        /*
                        |-----------------------------------
                        | Status
                        |-----------------------------------
                        */

                        Section::make('Status')
                            ->schema([
                                Toggle::make('is_active')
                                    ->label('Active')
                                    ->default(true),

                                Toggle::make('is_popular')
                                    ->label('Popular')
                                    ->default(false),
                            ])
                            ->columns(2)
                            ->secondary()
                            ->compact()
                            ->collapsible()
                            ->collapsed(false),

                    ])
                    ->compact()
                    ->columnSpanFull(),
            ]);
    }

    /*
    |----------------------------------------------------------------------
    | Helpers
    |----------------------------------------------------------------------
    */
    private static function resolvePriceAfterDiscount(?Plan $plan)
    {
        if (!$plan) {
            return;
        }
        
        $discount = $plan->getDiscount();
        $priceDiscount = $plan->getPriceDiscount();

        if ($discount === 0) {
            return null;
        }

        return 'Price after discount ' . number_format($priceDiscount) . ' EGP';
    }
}
