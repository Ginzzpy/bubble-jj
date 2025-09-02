<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::prefix('auth')->controller(AuthController::class)->group(function () {
  Route::middleware('guest')->group(function () {
    Route::get('/user', 'userLoginForm')->name('user.login');
    Route::get('/admin', 'adminLoginForm')->name('admin.login');
  });
});
