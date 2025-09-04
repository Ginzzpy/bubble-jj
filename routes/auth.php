<?php

use App\Http\Controllers\Auth as Auth;
use Illuminate\Support\Facades\Route;

/**
 * Auth routes
 */

/* --- Login route group --- */
Route::middleware('guest')->prefix('login')->name('login.')->group(function () {
  // User Login
  Route::controller(Auth\UserLoginController::class)->name('user.')->group(function () {
    Route::get('/user', 'loginForm')->name('view');
    Route::post('/user', 'login')->name('post');
  });

  // Admin Login
  Route::controller(Auth\AdminLoginController::class)->name('admin.')->group(function () {
    Route::get('/admin', 'loginForm')->name('view');
    Route::post('/admin', 'login')->name('post');
  });
});

/* --- User password route group --- */
Route::controller(Auth\UserPasswordController::class)->prefix('password')->name('password.')->group(function () {
  Route::middleware('guest')->name('set.')->group(function () {
    Route::get('/set', 'setForm')->name('view');
    Route::post('/set', 'set')->name('post');
  });

  Route::middleware('auth')->group(function () {
    Route::post('/check', 'check')->name('check');
  });
});

/* --- User register route group --- */
Route::middleware('guest')->controller(Auth\UserRegisterController::class)->name('register.')->group(function () {
  Route::get('/register', 'registerForm')->name('view');
  Route::post('/register', 'register')->name('post');
});

/* --- User email verification --- */
Route::middleware('auth')->prefix('email')->group(function () {
  Route::controller(Auth\EmailVerificationController::class)->prefix('verify')->name('verification.')->group(function () {
    Route::get('/verify', 'notice')->name('notice');
    Route::get('/verify/{id}/{hash}', 'verify')->middleware(['signed', 'auth'])->name('verify');
    Route::post('/verify/resend', 'resend')->name('resend');
  });
});

/* --- Logout route --- */
Route::post('/logout', [Auth\AdminLoginController::class, 'logout'])->name('logout');
