<?php

namespace App\Support\Exceptions;

use App\Domain\Panel\Actions\PanelResolverAction;
use App\Support\Context\AuthContext;

class ErrorRedirectResolver
{
    public function resolve(): string
    {
        if (AuthContext::guest()) {
            return '/';
        }

        return app(PanelResolverAction::class)->panelRoute(AuthContext::user());
    }
}
