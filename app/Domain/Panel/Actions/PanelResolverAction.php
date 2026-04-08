<?php

namespace App\Domain\Panel\Actions;

use App\Support\Enums\UserPanelEnum;
use Filament\Facades\Filament;
use Illuminate\Foundation\Auth\User;

class PanelResolverAction
{
    public static function panelRoute(User $user): string
    {
        return match(true) {
            $user->isAdminPanel()  => Filament::getPanel(UserPanelEnum::ADMIN->value)->getUrl(),
            $user->isUserPanel()   => Filament::getPanel(UserPanelEnum::USER->value)->getUrl(),
            default                => static::loginRoute(),
        };
    }

    public static function loginRoute(): string
    {
        return Filament::getPanel('auth')->getUrl();
    }
}