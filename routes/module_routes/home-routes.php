<?php

use App\Http\Controllers\HomeController;

Route::get('/home'                      ,[HomeController::class, 'index'                           ])->name('home');
Route::get('/training-event'            ,[HomeController::class, 'trainingCalendarEvents'          ])->name('events');
Route::get('/employee-overview'         ,[HomeController::class, 'employeeOverview'                ])->name('overview');
Route::get('/payroll'                   ,[HomeController::class, 'payroll'                         ])->name('payroll')->middleware('checkUserRole:1,2');
Route::get('/generated'                 ,[HomeController::class, 'generatedPayroll'                ])->name('generate')->middleware('checkUserRole:1,2');
Route::get('/attendance'                ,[HomeController::class, 'attendance'                      ])->name('attendance')->middleware('checkUserRole:1,2');
Route::get('/leave-request'             ,[HomeController::class, 'leaveRequest'                    ])->name('request')->middleware('checkUserRole:1,2');
Route::get('/training'                  ,[HomeController::class, 'training'                        ])->name('training')->middleware('checkUserRole:1,2');
Route::get('/activities'                ,[HomeController::class, 'activities'                      ])->name('activities')->middleware('checkUserRole:1');
