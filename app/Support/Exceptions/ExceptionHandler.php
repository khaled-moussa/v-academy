<?php

namespace App\Support\Exceptions;

use Illuminate\Foundation\Configuration\Exceptions;

class ExceptionHandler
{
    public function register(Exceptions $exceptions): void
    {
        $this->report($exceptions);
        // $this->render($exceptions);
    }

    private function report(Exceptions $exceptions): void
    {
        (new ExceptionReporter())->register($exceptions);
    }

    private function render(Exceptions $exceptions): void
    {
        (new HttpExceptionRenderer())->register($exceptions);
    }
}
