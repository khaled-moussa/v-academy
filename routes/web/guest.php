<?php

use App\App\Web\Controllers\Guest\Landing\LandingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
| Publicly accessible web routes.
|--------------------------------------------------------------------------
*/

Route::get('/', LandingController::class)
    ->name('landing');
