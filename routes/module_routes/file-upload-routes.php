<?php

use App\Http\Controllers\FileUploadController;

Route::prefix('file-upload')->as('file.')->group(function () {
    Route::get('/show'                          ,[FileUploadController::class, 'getAll'          ])->name('show');
    Route::post('/upload'                       ,[FileUploadController::class, 'upload'          ])->name('upload');
    Route::post('/revert'                       ,[FileUploadController::class, 'revert'          ])->name('revert');
    Route::post('/store/{token}'                ,[FileUploadController::class, 'store'           ])->name('store');
    Route::delete('/delete'                     ,[FileUploadController::class, 'delete'          ])->name('delete');
});
