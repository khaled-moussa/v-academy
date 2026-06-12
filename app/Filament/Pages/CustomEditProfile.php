<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Auth\Pages\EditProfile as BaseEditProfile;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;

class CustomEditProfile extends BaseEditProfile
{
    /*
    |--------------------------------------------------------------------------
    | Form Schema
    |--------------------------------------------------------------------------
    */

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            $this->getFirstNameFormComponent(),
            $this->getLastNameFormComponent(),
            $this->getPhoneFormComponent(),
            $this->getEmailFormComponent(),
            $this->getPasswordFormComponent(),
            $this->getCurrentPasswordFormComponent(),
            $this->getPasswordConfirmationFormComponent(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Form Field Definitions
    |--------------------------------------------------------------------------
    */

    /** Maps the name field to the `full_name` column instead of the default `name`. */
    protected function getFirstNameFormComponent(): Component
    {
        return parent::getNameFormComponent()->statePath('first_name');
    }

    protected function getLastNameFormComponent(): Component
    {
        return parent::getNameFormComponent()->statePath('last_name');
    }

    protected function getPhoneFormComponent(): Component
    {
        return TextInput::make('phone')
            ->label('Phone')
            ->unique(ignoreRecord: true)
            ->placeholder('No phone')
            ->maxLength(255);
    }

    /*
    |--------------------------------------------------------------------------
    | Page Actions
    |--------------------------------------------------------------------------
    */

    public function backAction(): Action
    {
        return Action::make('back_to_home')
            ->label('Back to home')
            ->outlined()
            ->action(fn() => redirect(Filament::getUrl()));
    }
}
