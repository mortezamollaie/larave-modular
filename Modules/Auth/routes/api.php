<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AuthController;

Route::middleware([])->prefix('v1')->group(function () {
    Route::post('check-user', [AuthController::class, 'checkUser'])
        ->name('check-user')
        ->middleware('throttle:check-user');
});
