<?php

namespace App\Filament\Panels\Admin\Resources\Sessions\Schemas;

use App\Domain\TrainingSession\Models\SessionStates\SessionAvailableState;
use App\Domain\TrainingSession\Models\SessionStates\SessionStates;
use App\Support\Context\AuthContext;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

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

                        TextInput::make('capacity')
                            ->label('Capacity')
                            ->numeric()
                            ->minValue(1)
                            ->required()
                            ->prefixIcon(Heroicon::OutlinedUsers),

                        Select::make('session_state')
                            ->label('Session State')
                            ->required()
                            ->options(SessionStates::options())
                            ->default(SessionAvailableState::value())
                            ->native(false)
                            ->prefixIcon(Heroicon::OutlinedCheckBadge),

                        DatePicker::make('session_date_formatted')
                            ->label('Session Date')
                            ->required()
                            ->displayFormat('M d, Y')
                            ->firstDayOfWeek(1) // Saturady
                            ->placeholder('Select a date')
                            ->native(false),

                        TimePicker::make('session_time_formatted')
                            ->label('Session Time')
                            ->required()
                            ->displayFormat('h:i A')
                            ->seconds(false)
                            ->native(false)
                            ->placeholder('Select a time'),

                        /*
                        |-----------------------------------
                        | #Hidden Default
                        |-----------------------------------
                        */

                        Hidden::make('user_created_session_id')
                            ->default(AuthContext::id()),

                        Hidden::make('is_admin_created')
                            ->default(true),

                    ])
                    ->columns(2)
                    ->compact()
                    ->secondary()
                    ->columnSpanFull(),
            ]);
    }
}
