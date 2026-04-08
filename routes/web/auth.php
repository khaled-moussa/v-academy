<?php

use App\App\Web\Controllers\Auth\SocialiteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
| Routes related to user authentication and account security.
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| Socialite Authentication Routes
|--------------------------------------------------------------------------
*/
Route::controller(SocialiteController::class)
    ->prefix('auth')
    ->as('auth.')
    ->group(function () {
        Route::get('redirect/{provider}', 'redirect')
            ->name('redirect');

        Route::get('callback/{provider}', 'callback')
            ->name('callback');
    });
