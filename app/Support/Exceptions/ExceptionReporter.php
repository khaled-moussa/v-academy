<?php

namespace App\Support\Exceptions;

use Illuminate\Foundation\Configuration\Exceptions;

class ExceptionReporter
{
    public function register(Exceptions $exceptions): void
    {
        $exceptions->dontReportDuplicates();
    }
}
