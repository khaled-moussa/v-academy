<?php

namespace App\Filament\Pages;

use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;

class CustomLogin extends BaseLogin
{
    public function mount(): void
    {
        parent::mount();

        if (session()->has('failed_login_message')) {
            Notification::make()
                ->title('Login Failed')
                ->body(session('failed_login_message'))
                ->danger()
                ->send();

            session()->forget('failed_login_message');
        }
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            $this->getEmailFormComponent(),
            $this->getPasswordFormComponent(),
            $this->getRememberFormComponent(),
        ]);
    }
}
