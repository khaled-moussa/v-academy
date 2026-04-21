<?php

namespace App\Filament\Panels\User\Resources\Sessions\Schemas;

use App\Support\Context\AuthContext;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SessionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Training Session Details')
                    ->schema([

                        /*
                        |-----------------------------------
                        | Basic Information
                        |-----------------------------------
                        */
                        TextInput::make('name')
                            ->label('Session Name')
                            ->nullable()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        DatePicker::make('session_date')
                            ->label('Session Date')
                            ->required()
                            ->displayFormat('M d, Y')
                            ->firstDayOfWeek(1)
                            ->placeholder('Select a date')
                            ->native(false),

                        TimePicker::make('session_time')
                            ->label('Session Time')
                            ->required()
                            ->displayFormat('h:i A')
                            ->seconds(false)
                            ->placeholder('Select a time')
                            ->native(false),

                        /*
                        |-----------------------------------
                        | #Hidden Default
                        |-----------------------------------
                        */
                        Hidden::make('capacity')
                            ->default(app('generalSetting')['max_capacity']),

                        Hidden::make('user_created_session_id')
                            ->default(AuthContext::id()),

                        Hidden::make('is_admin_created')
                            ->default(false),
                    ])
                    ->columns(2)
                    ->compact()
                    ->secondary()
                    ->columnSpanFull(),
            ]);
    }
}
