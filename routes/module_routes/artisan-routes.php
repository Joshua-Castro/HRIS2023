<?php

use App\Http\Controllers\ArtisanController;

Route::prefix('artisan')->as('artisan.')->group(function () {
    Route::get('/cache-clear'   ,[ArtisanController::class, 'runCacheClear' ])->name('cache-clear')->middleware('checkUserRole:1');
    Route::get('/migrate'       ,[ArtisanController::class, 'migrate'       ])->name('migrate')->middleware('checkUserRole:1');
    Route::get('/seed'          ,[ArtisanController::class, 'seed'          ])->name('seed')->middleware('checkUserRole:1');
});
