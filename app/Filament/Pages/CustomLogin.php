<?php

namespace App\Filament\Pages;

use App\Filament\Components\Notification\CustomNotification;
use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Schemas\Schema;

class CustomLogin extends BaseLogin
{
    public function mount(): void
    {
        parent::mount();

        $this->handleFailedLoginMessage();
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            $this->getEmailFormComponent(),
            $this->getPasswordFormComponent(),
            $this->getRememberFormComponent(),
        ]);
    }

    /*
    |-----------------------------------
    | Helpers
    |-----------------------------------
    */

    private function handleFailedLoginMessage(): void
    {
        $message = session()->pull('failed_login_message');

        if (! $message) {
            return;
        }

        CustomNotification::error(title: $message);
    }
}
