<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;


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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('employee')->as('employee.')->group(function () {
    Route::post('/store'    ,[EmployeeController::class, 'store'    ])->name('store');
    Route::get('/show'      ,[EmployeeController::class, 'show'      ])->name('show');
    Route::post('/delete'   ,[EmployeeController::class, 'destroy'   ])->name('delete');
});