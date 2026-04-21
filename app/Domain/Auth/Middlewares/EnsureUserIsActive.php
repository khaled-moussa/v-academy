<?php

namespace App\Domain\Auth\Middlewares;

use App\Domain\Panel\Actions\PanelResolverAction;
use App\Support\Context\AuthContext;
use Illuminate\Http\Request;
use Closure;

class EnsureUserIsActive
{
    public function handle(Request $request, Closure $next)
    {
        /*
        |-----------------------------------
        | Not Authenticated
        |-----------------------------------
        */

        if (AuthContext::guest()) {
            return redirect(PanelResolverAction::loginRoute());
        }

        /*
        |-----------------------------------
        | Inactive User
        |-----------------------------------
        */

        if (! AuthContext::isActive()) {
            AuthContext::logout();

            session()->put('failed_login_message', 'Your account has been disabled. Please contact the administrator.');

            return redirect(PanelResolverAction::loginRoute());
        }

        /*
        |-----------------------------------
        | Continue Request
        |-----------------------------------
        */

        return $next($request);
    }
}
