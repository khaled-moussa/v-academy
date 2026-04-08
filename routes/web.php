<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| The web routes for the application.
| Additional route files are loaded for better organization.
|--------------------------------------------------------------------------
*/

// Authentication routes
require base_path('routes/web/auth.php');

// Public (guest) routes
require base_path('routes/web/guest.php');

// Test routes
// require base_path('routes/web/test.php');
