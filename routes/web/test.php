<?php

use App\Domain\Request\Core\Models\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Browsershot\Browsershot;

Route::get('/', function () {
    return view('welcome');
})->name('home');
