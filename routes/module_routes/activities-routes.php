<?php

use App\Http\Controllers\LogController;

Route::prefix('log')->as('log.')->group(function () {
    Route::get('/show',     [LogController::class, 'show'             ])->name('show');
});
