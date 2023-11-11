<?php

use App\Http\Controllers\PayrollController;

Route::prefix('payroll')->as('payroll.')->group(function () {
    Route::get('/show', [PayrollController::class, 'show'])->name('show');
});
