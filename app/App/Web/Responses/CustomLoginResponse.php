<?php

namespace App\App\Web\Responses;

use App\Domain\Panel\Actions\PanelResolverAction;
use App\Support\Context\AuthContext;
use Filament\Auth\Http\Responses\LoginResponse as BaseLoginResponse;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

class CustomLoginResponse extends BaseLoginResponse
{
    public function toResponse($request): RedirectResponse | Redirector
    {
        if (! AuthContext::check()) {
            return redirect(PanelResolverAction::loginRoute());
        }

        if (! AuthContext::isActive()) {

            AuthContext::logout();

            session()->put('failed_login_message', __('Your account has been disabled. Please contact the administrator.'));

            return redirect(PanelResolverAction::loginRoute());
        }

        return redirect(PanelResolverAction::panelRoute(AuthContext::user()));
    }
}
