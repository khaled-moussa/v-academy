<?php

namespace App\App\Web\Responses;

use App\Domain\Panel\Actions\PanelResolverAction;
use Filament\Auth\Http\Responses\LoginResponse as BaseLoginResponse;
use Filament\Notifications\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Livewire\Features\SupportRedirects\Redirector;

class CustomLoginResponse extends BaseLoginResponse
{
    public function toResponse($request): RedirectResponse | Redirector
    {
        $user = $request->user();

        if (! $user->isActive()) {
            Auth::logout();

            Notification::make()
                ->title('Account Disabled')
                ->body('Your account has been disabled. Please contact the administrator.')
                ->danger()
                ->persistent()
                ->send();

            return redirect(PanelResolverAction::loginRoute());
        }

        return redirect(PanelResolverAction::panelRoute($user));
    }
}