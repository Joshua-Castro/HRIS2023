<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\AttendanceController;


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

Route::get('/home'                      ,[App\Http\Controllers\HomeController::class, 'index'                           ])->name('home');
Route::get('/request'                   ,[App\Http\Controllers\HomeController::class, 'request'                         ])->name('request');
Route::get('/attendance'                ,[App\Http\Controllers\HomeController::class, 'attendance'                      ])->name('attendance');
Route::get('/training'                  ,[App\Http\Controllers\HomeController::class, 'training'                        ])->name('training');
Route::get('/training-event'            ,[App\Http\Controllers\HomeController::class, 'trainingCalendarEvents'          ])->name('events');
Route::get('/employee-overview'         ,[App\Http\Controllers\HomeController::class, 'employeeOverview'                ])->name('overview');
Route::get('/activities'                ,[App\Http\Controllers\HomeController::class, 'activities'                      ])->name('activities');

// EMPLOYEE CONTROLLER ROUTES
Route::prefix('employee')->as('employee.')->group(function () {
    Route::post('/store'    ,[EmployeeController::class, 'store'     ])->name('store');
    Route::get('/show'      ,[EmployeeController::class, 'show'      ])->name('show');
    Route::post('/delete'   ,[EmployeeController::class, 'destroy'   ])->name('delete');
});

// FILE UPLOAD CONTROLLER ROUTES
Route::prefix('file-upload')->as('file.')->group(function () {
    Route::post('/store/{token}'                ,[FileUploadController::class, 'store'           ])->name('store');
    Route::post('/upload'                       ,[FileUploadController::class, 'upload'          ])->name('upload');
    Route::delete('/delete'                     ,[FileUploadController::class, 'delete'          ])->name('delete');
    Route::post('/revert'                       ,[FileUploadController::class, 'revert'          ])->name('revert');
    Route::get('/show'                          ,[FileUploadController::class, 'getAll'          ])->name('show');
});

// LEAVE CONTROLLER ROUTES
Route::prefix('leave')->as('leave.')->group(function () {
    Route::get('/show'      ,[LeaveController::class, 'show'      ])->name('show');
    Route::get('/show-all'  ,[LeaveController::class, 'showAll'   ])->name('show.all');
    Route::post('/store'    ,[LeaveController::class, 'store'     ])->name('store');
    Route::post('/delete'   ,[LeaveController::class, 'destroy'   ])->name('delete');
    Route::post('/update'   ,[LeaveController::class, 'update'    ])->name('update');
});

// ATTENDANCE CONTROLLER ROUTES
Route::prefix('attendance')->as('attendance.')->group(function () {
    Route::get('/show'                      ,[AttendanceController::class, 'show'                ])->name('show');
    Route::post('/store'                    ,[AttendanceController::class, 'store'               ])->name('store');
    Route::get('/daily-attendance'          ,[AttendanceController::class, 'dailyAttendance'     ])->name('daily');
    Route::get('/get-attendace'             ,[AttendanceController::class, 'attendanceRecord'    ])->name('record');
    Route::get('/get-all-attendace'         ,[AttendanceController::class, 'getAllAttendance'    ])->name('all');
});

// TRAINING/SEMINARS CONTROLLER ROUTES
Route::prefix('training')->as('training.')->group(function () {
    Route::post('/store'       ,[TrainingController::class, 'store'     ])->name('store');
    Route::get('/show'         ,[TrainingController::class, 'show'      ])->name('show');
    Route::post('/delete'      ,[TrainingController::class, 'destroy'   ])->name('delete');
});

// PROFILE CONTROLLER ROUTES
Route::prefix('profile')->as('profile.')->group(function () {
    Route::get('/'                  ,[ProfileController::class, 'index'            ])->name('index');
    Route::get('/show'              ,[ProfileController::class, 'show'             ])->name('show');
    Route::post('/update-info'      ,[ProfileController::class, 'updateInfo'       ])->name('update.info');
});

// ACTIVITIES OR LOGS CONTROLLER ROUTES

