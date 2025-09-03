<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['role:user', 'auth'])->prefix('user')->name('user.')->group(function () {
    Route::middleware('verified')->group(function () {
        // 
    });

    Route::get('/dashboard', function (Request $request) {
        return spaRender($request, 'pages.user.dashboard');
    })->name('dashboard');
});
