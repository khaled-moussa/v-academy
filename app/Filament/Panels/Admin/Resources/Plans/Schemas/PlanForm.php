<?php

namespace App\Filament\Panels\Admin\Resources\Plans\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Textarea;
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
                                    ->placeholder('Enter plan name')
                                    ->columnSpanFull(),

                                Textarea::make('description')
                                    ->label('Description')
                                    ->required()
                                    ->rows(3)
                                    ->placeholder('Enter plan description')
                                    ->columnSpanFull(),

                                TextInput::make('price')
                                    ->label('Price')
                                    ->required()
                                    ->numeric()
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->minValue(1)
                                    ->suffix('EGP'),

                                TextInput::make('no_of_sessions')
                                    ->label('Number of Sessions')
                                    ->numeric()
                                    ->required()
                                    ->placeholder('Enter number of sessions'),
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
                            ])
                            ->secondary()
                            ->compact()
                            ->collapsible()
                            ->collapsed(false),

                    ])
                    ->compact()
                    ->columnSpanFull(),
            ]);
    }
}
