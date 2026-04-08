<?php

namespace App\Filament\Pages;

use App\Domain\SocialAccount\Actions\GetSocialAccountBySocialIdAction;
use App\Domain\SocialAccount\Actions\ResolveSocialAccountLinkedWithUserAction;
use App\Domain\SocialAccount\Actions\UnlinkSocialAccountAction;
use App\Domain\SocialAccount\Dtos\SocialAccountDto;
use App\Domain\User\Actions\ResolveCurrentUserAction;
use Filament\Actions\Action;
use Filament\Auth\Pages\EditProfile as BaseEditProfile;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Size;
use Filament\Support\Icons\Heroicon;
use Livewire\Attributes\On;

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
            $this->getNameFormComponent(),
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
    protected function getNameFormComponent(): Component
    {
        return parent::getNameFormComponent()->statePath('full_name');
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