<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::prefix('auth')->controller(AuthController::class)->group(function () {
  Route::middleware('guest:admin,viewer')->group(function () {
    Route::get('/admin', 'adminLoginForm')->name('admin-login');
    Route::get('/viewer', 'viewerLoginForm')->name('viewer-login');
    Route::post('/login', 'login')->name('login.post');
  });

  Route::post('/logout', 'logout')->name('logout');
});
