<?php

namespace App\Filament\Panels\User\Resources\Sessions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;

class SessionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                /*
                |------------------------------------------------------------------
                | Session Details
                |------------------------------------------------------------------
                */

                Section::make('Session Details')
                    ->schema([

                        /*
                        |-----------------------------
                        | Basic Info
                        |-----------------------------
                        */

                        TextEntry::make('uuid')
                            ->label('Reference')
                            ->badge()
                            ->color(Color::Orange)
                            ->copyable(),

                        TextEntry::make('name')
                            ->label('Session Name'),

                        TextEntry::make('capacity')
                            ->label('Capacity')
                            ->badge()
                            ->color(Color::Indigo),

                        TextEntry::make('session_state')
                            ->label('State')
                            ->badge()
                            ->color(fn($state) => $state->filamentColor())
                            ->formatStateUsing(fn($state) => $state->label()),

                        TextEntry::make('session_date_formatted')
                            ->label('Date')
                            ->date()
                            ->badge(),

                        TextEntry::make('session_time_formatted')
                            ->label('Time')
                            ->time()
                            ->badge(),

                        /*
                        |-----------------------------
                        | Created By (Conditional)
                        |-----------------------------
                        */

                        // (if admin created)
                        Section::make('Created By')
                            ->afterHeader([
                                TextEntry::make('admin_badge')
                                    ->hiddenLabel()
                                    ->state('Admin')
                                    ->badge()
                                    ->color(Color::Orange)
                            ])
                            ->relationship('user')
                            ->visible(fn($record) => $record->isAdminCreated())
                            ->schema([
                                TextEntry::make('full_name')
                                    ->label('Name'),

                                TextEntry::make('email')
                                    ->label('Email')
                                    ->copyable(),

                                TextEntry::make('phone')
                                    ->label('Phone')
                                    ->copyable()
                                    ->placeholder('No phone'),
                            ])
                            ->columnSpanFull()
                            ->columns(2)
                            ->compact()
                            ->secondary(),

                        // (if NOT admin created)
                        Section::make('Created By')
                            ->relationship('user')
                            ->visible(fn($record) => ! $record->isAdminCreated())
                            ->schema([
                                TextEntry::make('full_name')
                                    ->label('Name')
                                    ->badge(),
                            ])
                            ->columnSpanFull()
                            ->compact()
                            ->secondary(),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->compact()
                    ->secondary(),
            ]);
    }
}
