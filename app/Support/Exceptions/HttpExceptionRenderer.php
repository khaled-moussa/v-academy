<?php

namespace App\Support\Exceptions;

use Illuminate\Foundation\Configuration\Exceptions;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class HttpExceptionRenderer
{
    public function register(Exceptions $exceptions): void
    {
        $exceptions->renderable(function (Throwable $e, $request) {

            // Skip API responses
            if ($request->expectsJson()) {
                return null;
            }

            $status = $e instanceof HttpExceptionInterface
                ? $e->getStatusCode()
                : 500;

            /*
            |-------------------------------
            | Handle ALL 5xx Errors
            |-------------------------------
            */

            if ($status != 503 && $status >= 500 && $status < 600) {
                return redirect(app(ErrorRedirectResolver::class)->resolve())
                    ->with('server_error', __('Something went wrong. Please try again.'));
            }
        });
    }
}
