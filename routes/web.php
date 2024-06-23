<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/home');
    } else {
        return view('auth.login');
    }
});

Route::get('/optimize-clear', function () {
    Artisan::call('cache:clear');
});

// Route::get('/foo', function () {
//     Artisan::call('storage:link');
// });

Route::get('/migrate-refresh', function () {
    Artisan::call('migrate:refresh');
});

// Route::get('/migrate', function () {
//     Artisan::call('migrate');
// });

Route::get('/db-seed', function () {
    Artisan::call('db:seed');
});

Auth::routes();

Route::middleware(['web', 'auth'])->group(function () {
    // HOME CONTROLLER ROUTES
    require base_path('routes/module_routes/home-routes.php');

    // EMPLOYEE CONTROLLER ROUTES
    require base_path('routes/module_routes/employee-routes.php');

    // FILE UPLOAD CONTROLLER ROUTES
    require base_path('routes/module_routes/file-upload-routes.php');

    // LEAVE CONTROLLER ROUTES
    require base_path('routes/module_routes/leave-routes.php');

    // ATTENDANCE CONTROLLER ROUTES
    require base_path('routes/module_routes/attendance-routes.php');

    // TRAINING/SEMINARS CONTROLLER ROUTES
    require base_path('routes/module_routes/training-routes.php');

    // PROFILE CONTROLLER ROUTES
    require base_path('routes/module_routes/profile-routes.php');

    // ACTIVITIES OR LOGS CONTROLLER ROUTES
    require base_path('routes/module_routes/activities-routes.php');

    // PAYROLL CONTROLLER ROUTES
    require base_path('routes/module_routes/payroll-routes.php');

    // ARTISAN COMMAND CONTROLL
    // require base_path('routes/module_routes/artisan-routes.php');
});

