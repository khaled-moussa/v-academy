<?php

namespace App\App\Web\Controllers\Landing;

use App\Domain\Plan\Actions\GetPlansAction;

class LandingController
{
    public function __invoke()
    {
        $plans = app(GetPlansAction::class)
            ->execute()
            ->toResourceCollection();

        return view('pages.landing.index', [
            'plans' => $plans
        ]);
    }
}
