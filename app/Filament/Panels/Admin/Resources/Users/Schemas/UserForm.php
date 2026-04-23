<?php

namespace App\Filament\Panels\Admin\Resources\Users\Schemas;

use App\Support\Enums\GenderEnum;
use App\Support\Enums\UserPanelEnum;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('User Form')
                    ->tabs([
                        self::profileTab(),
                        self::nutritionPlanTab(),
                    ])
                    ->columnSpanFull()
                    ->contained(false),
            ]);
    }

    /*
    |-------------------------------
    | Profile Tab
    |-------------------------------
    */
    protected static function profileTab(): Tab
    {
        return Tab::make('Profile')
            ->schema([
                Section::make()
                    ->schema([

                        /*
                        |-------------------------------
                        | Basic Information Section
                        |-------------------------------
                        */
                        Section::make('Basic Information')
                            ->schema([
                                TextInput::make('first_name')
                                    ->label('First Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Enter first name'),

                                TextInput::make('last_name')
                                    ->label('Last Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Enter last name'),

                                TextInput::make('email')
                                    ->label('Email')
                                    ->required()
                                    ->email()
                                    ->unique(ignoreRecord: true)
                                    ->prefixIcon(Heroicon::OutlinedEnvelope)
                                    ->placeholder('Enter email address'),

                                TextInput::make('phone')
                                    ->label('Phone')
                                    ->tel()
                                    ->unique(ignoreRecord: true)
                                    ->nullable()
                                    ->prefixIcon(Heroicon::OutlinedPhone)
                                    ->placeholder('Enter phone number'),

                                TextInput::make('age')
                                    ->label('Age')
                                    ->numeric()
                                    ->minValue(6)
                                    ->nullable()
                                    ->placeholder('Enter age'),

                                Select::make('gender')
                                    ->label('Gender')
                                    ->required()
                                    ->options(GenderEnum::options())
                                    ->native(false)
                                    ->placeholder('Select gender'),
                            ])
                            ->columns(2)
                            ->secondary()
                            ->collapsible()
                            ->collapsed(false),

                        /*
                        |-------------------------------
                        | Physical & Sports Info Section
                        |-------------------------------
                        */
                        Section::make('Physical & Sports Info')
                            ->schema([
                                TextInput::make('sport')
                                    ->label('Sport')
                                    ->required()
                                    ->placeholder('Enter sport or activity'),

                                Textarea::make('current_injury')
                                    ->label('Current Injury')
                                    ->nullable()
                                    ->placeholder('Describe any current injuries'),

                                Textarea::make('previous_injury')
                                    ->label('Previous Injuries')
                                    ->nullable()
                                    ->placeholder('Describe any past injuries'),

                                Section::make()
                                    ->schema([
                                        TextInput::make('weight')
                                            ->label('Weight (kg)')
                                            ->numeric()
                                            ->nullable()
                                            ->placeholder('Enter weight'),

                                        TextInput::make('height')
                                            ->label('Height (cm)')
                                            ->numeric()
                                            ->nullable()
                                            ->placeholder('Enter height'),
                                    ])
                                    ->columns(2)
                                    ->contained(false),
                            ])
                            ->secondary()
                            ->collapsible(),

                        /*
                        |-------------------------------
                        | Additional Info Section
                        |-------------------------------
                        */
                        Section::make('Additional Info')
                            ->schema([
                                TextInput::make('address')
                                    ->label('Address')
                                    ->nullable()
                                    ->columnSpanFull()
                                    ->prefixIcon(Heroicon::OutlinedMap)
                                    ->placeholder('Enter address'),

                                Textarea::make('notes')
                                    ->label('Notes')
                                    ->nullable()
                                    ->columnSpanFull()
                                    ->placeholder('Any additional notes'),
                            ])
                            ->secondary()
                            ->collapsible(),

                        /*
                        |-------------------------------
                        | Access & Security Section
                        |-------------------------------
                        */

                        Section::make('Access & Security')
                            ->schema([
                                TextInput::make('password')
                                    ->label('Password')
                                    ->password()
                                    ->visibleOn(['create'])
                                    ->belowLabel('If you provide a password, the user will receive an email with a link to set their own password.')
                                    ->prefixIcon(Heroicon::OutlinedLockClosed)
                                    ->placeholder('Enter password'),

                                Toggle::make('is_active')
                                    ->label('Active')
                                    ->default(true),

                                Hidden::make('panel')
                                    ->default(UserPanelEnum::USER),
                            ])
                            ->secondary()
                            ->collapsible()
                            ->collapsed(false),
                    ])
                    ->compact()
                    ->columnSpanFull(),
            ]);
    }

    /*
    |-------------------------------
    | Nutrition Plan Tab
    |-------------------------------
    */
    protected static function nutritionPlanTab(): Tab
    {
        return Tab::make('Nutrition Plan')
            ->schema([
                Section::make('Nutrition Plan')
                    ->description('Manage the user\'s nutrition plan here.')
                    ->schema([
                        Repeater::make('nutrationPlans')
                            ->label('Nutrition Plans')
                            ->relationship('nutrationPlans')
                            ->table([
                                TableColumn::make('Meal'),
                                TableColumn::make('Sat'),
                                TableColumn::make('Sun'),
                                TableColumn::make('Mon'),
                                TableColumn::make('Tue'),
                                TableColumn::make('Wed'),
                                TableColumn::make('Thu'),
                                TableColumn::make('Fri'),
                            ])
                            ->schema([
                                TextInput::make('meal')
                                    ->label('Meal'),

                                TextInput::make('saturday')
                                    ->label('Sat'),

                                TextInput::make('sunday')
                                    ->label('Sun'),

                                TextInput::make('monday')
                                    ->label('Mon'),

                                TextInput::make('tuesday')
                                    ->label('Tue'),

                                TextInput::make('wednesday')
                                    ->label('Wed'),

                                TextInput::make('thursday')
                                    ->label('Thu'),

                                TextInput::make('friday')
                                    ->label('Fri'),

                            ])
                            ->columns(4), // optional: adjust columns for layout
                    ])
                    ->columns(1),
            ]);
    }
}
