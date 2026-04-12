<?php

namespace App\Filament\Pages;

use App\Support\Enums\GenderEnum;
use App\Support\Enums\UserPanelEnum;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class CustomRegister extends BaseRegister
{
    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Wizard::make([
                $this->accountStep(),
                $this->sportsStep(),
            ])
                ->submitAction($this->getRegisterFormAction())
                ->columnSpanFull()
                ->contained(false)
        ]);
    }

    /*
    |----------------------------------------------------------------------
    | Steps
    |----------------------------------------------------------------------
    */

    private function accountStep(): Step
    {
        return Step::make('Account')
            ->icon(Heroicon::OutlinedUser)
            ->schema([
                $this->getNameSectionFormComponent(),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
                $this->getPhoneFormComponent(),
                $this->getDefaultValuesComponent(),
            ]);
    }

    private function sportsStep(): Step
    {
        return Step::make('Sports Info')
            ->icon(Heroicon::OutlinedBolt)
            ->schema([
                TextInput::make('age')
                    ->label('Age')
                    ->required()
                    ->numeric()
                    ->minValue(6)
                    ->placeholder('Enter age'),

                Select::make('gender')
                    ->label('Gender')
                    ->required()
                    ->options(GenderEnum::options())
                    ->native(false)
                    ->placeholder('Select gender'),

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

                TextInput::make('weight')
                    ->label('Weight (kg)')
                    ->required()
                    ->numeric(),

                TextInput::make('height')
                    ->label('Height (cm)')
                    ->required()
                    ->numeric(),

                TextInput::make('address')
                    ->label('Address')
                    ->nullable()
                    ->columnSpanFull()
                    ->prefixIcon(Heroicon::OutlinedMap),

                Textarea::make('notes')
                    ->label('Notes')
                    ->nullable()
                    ->columnSpanFull(),
            ])
            ->columnSpanFull();
    }

    /*
    |----------------------------------------------------------------------
    | Fields
    |----------------------------------------------------------------------
    */

    private function getNameSectionFormComponent(): Section
    {
        return Section::make()
            ->schema([
                TextInput::make('first_name')
                    ->label('First Name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('last_name')
                    ->label('Last Name')
                    ->required()
                    ->maxLength(255),
            ])
            ->columnSpanFull()
            ->contained(false);
    }

    private function getPhoneFormComponent(): TextInput
    {
        return TextInput::make('phone')
            ->label('Phone')
            ->tel()
            ->unique($this->getUserModel())
            ->nullable()
            ->prefix('+20')
            ->prefixIcon(Heroicon::OutlinedPhone)
            ->placeholder('Enter phone number');
    }

    /*
    |----------------------------------------------------------------------
    | Actions
    |----------------------------------------------------------------------
    */
    private function getDefaultValuesComponent(): Hidden
    {
        return Hidden::make('panel')
            ->default(UserPanelEnum::USER);
    }

    /*
    |----------------------------------------------------------------------
    | Actions
    |----------------------------------------------------------------------
    */

    protected function getFormActions(): array
    {
        return [];
    }
}
