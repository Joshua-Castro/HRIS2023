<?php

use App\Http\Controllers\EmployeeController;

Route::prefix('employee')->as('employee.')->group(function () {
    Route::post('/store'    ,[EmployeeController::class, 'store'     ])->name('store');
    Route::get('/show'      ,[EmployeeController::class, 'show'      ])->name('show');
    Route::post('/delete'   ,[EmployeeController::class, 'destroy'   ])->name('delete');
});
