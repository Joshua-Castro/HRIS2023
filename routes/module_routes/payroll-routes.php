<?php

use App\Http\Controllers\PayrollController;

Route::prefix('payroll')->as('payroll.')->group(function () {
    Route::get('/show'                      ,[PayrollController::class, 'show'                      ])->name('show');
    Route::post('/store'                    ,[PayrollController::class, 'store'                     ])->name('store');
    Route::get('/employee-attendance'       ,[PayrollController::class, 'getEmployeeAttendance'     ])->name('employee.attendance');
});
