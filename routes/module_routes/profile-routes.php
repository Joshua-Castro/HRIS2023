<?php

use App\Http\Controllers\ProfileController;

Route::prefix('profile')->as('profile.')->group(function () {
    Route::get('/'                  ,[ProfileController::class, 'index'            ])->name('index');
    Route::get('/show'              ,[ProfileController::class, 'show'             ])->name('show');
    Route::post('/update-info'      ,[ProfileController::class, 'updateInfo'       ])->name('update.info');
});
