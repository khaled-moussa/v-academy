<?php

namespace App\Domain\Auth\Middlewares;

use App\Domain\Panel\Actions\PanelResolverAction;
use App\Support\Context\UserContext;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticatedToDashboard
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            return redirect(PanelResolverAction::panelRoute(UserContext::user()));
        }

        return $next($request);
    }
}
