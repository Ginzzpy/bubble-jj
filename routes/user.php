<?php

use App\Http\Controllers\User\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['role:user', 'auth'])->prefix('user')->name('user.')->group(function () {
    Route::middleware('verified')->group(function () {
        // 
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
