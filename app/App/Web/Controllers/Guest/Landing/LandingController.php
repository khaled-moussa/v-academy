<?php

namespace App\App\Web\Controllers\Guest\Landing;

class LandingController
{
    public function __invoke()
    {
        return view('pages.guest.landing.index');
    }
}
