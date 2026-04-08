<?php

namespace App\Filament\Panels\Admin\Resources\Plans\Schemas;

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
                                    ->weight('bold'),

                                Section::make('Description')
                                    ->schema([
                                        TextEntry::make('description')
                                            ->hiddenLabel()
                                            ->placeholder('No description'),
                                    ])
                                    ->columnSpanFull()
                                    ->compact()
                                    ->secondary(),

                                TextEntry::make('no_of_sessions')
                                    ->label('Number of Sessions')
                                    ->badge(),

                                TextEntry::make('price')
                                    ->label('Price')
                                    ->badge()
                                    ->money('EGP', locale: 'ln'),
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

                                TextEntry::make('created_at')
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
}
