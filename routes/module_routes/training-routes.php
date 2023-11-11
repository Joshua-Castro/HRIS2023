<?php

use App\Http\Controllers\TrainingController;

Route::prefix('training')->as('training.')->group(function () {
    Route::post('/store'       ,[TrainingController::class, 'store'     ])->name('store');
    Route::post('/delete'      ,[TrainingController::class, 'destroy'   ])->name('delete');
    Route::get('/show'         ,[TrainingController::class, 'show'      ])->name('show');
});
