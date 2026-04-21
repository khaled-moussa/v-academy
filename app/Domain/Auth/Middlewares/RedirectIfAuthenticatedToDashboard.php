<?php

namespace App\Domain\Auth\Middlewares;

use App\Domain\Panel\Actions\PanelResolverAction;
use App\Support\Context\AuthContext;
use Illuminate\Http\Request;
use Closure;

class RedirectIfAuthenticatedToDashboard
{
    public function handle(Request $request, Closure $next)
    {
        if (! AuthContext::check()) {
            return $next($request);
        }

        return redirect(PanelResolverAction::panelRoute(AuthContext::user()));
    }
}
