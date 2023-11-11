<?php

use App\Http\Controllers\AttendanceController;

Route::prefix('attendance')->as('attendance.')->group(function () {
    Route::get('/show'                      ,[AttendanceController::class, 'show'                ])->name('show');
    Route::get('/daily-attendance'          ,[AttendanceController::class, 'dailyAttendance'     ])->name('daily');
    Route::get('/get-attendace'             ,[AttendanceController::class, 'attendanceRecord'    ])->name('record');
    Route::get('/get-all-attendace'         ,[AttendanceController::class, 'getAllAttendance'    ])->name('all');
    Route::post('/store'                    ,[AttendanceController::class, 'store'               ])->name('store');
});
