<?php

use Illuminate\Support\Facades\Route;
use Modricl\Activator\Http\Controllers\ActivatorController;

Route::group(['prefix' => '/activator', 'middleware' => ['activator']], function () {
    Route::get('/code/generate', [ActivatorController::class, 'generateCode'])->name('activator.code.request');
    Route::post('/code/validate', [ActivatorController::class, 'validateCode'])->name('activator.code.validate');
});
