<?php

use App\Http\Controllers\LeaveController;

Route::prefix('leave')->as('leave.')->group(function () {
    Route::get('/show'      ,[LeaveController::class, 'show'      ])->name('show');
    Route::get('/show-all'  ,[LeaveController::class, 'showAll'   ])->name('show.all');
    Route::post('/store'    ,[LeaveController::class, 'store'     ])->name('store');
    Route::post('/delete'   ,[LeaveController::class, 'destroy'   ])->name('delete');
    Route::post('/update'   ,[LeaveController::class, 'update'    ])->name('update');
});
