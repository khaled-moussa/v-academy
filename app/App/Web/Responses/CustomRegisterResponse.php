<?php

namespace App\App\Web\Responses;

use App\Domain\Panel\Actions\PanelResolverAction;
use Filament\Auth\Http\Responses\RegistrationResponse as BaseRegistrationResponse;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

class CustomRegisterResponse extends BaseRegistrationResponse
{
    public function toResponse($request): RedirectResponse | Redirector
    {
        $user = $request->user();

        return redirect(PanelResolverAction::panelRoute($user));
    }
}
