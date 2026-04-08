<?php

namespace App\Support\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    public function register(): void
    {
        $this->renderable(function (Throwable $e, $request) {

            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Error happening try again later'
                ], 500);
            }

            return null;
        });
    }
}
