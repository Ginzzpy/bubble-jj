<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::prefix('auth')->controller(AuthController::class)->group(function () {
  Route::middleware('guest')->group(function () {
    Route::get('/user', 'userLoginForm')->name('user.login-view');
    Route::post('/user', 'userLogin')->name('user.login');

    Route::get('/admin', 'adminLoginForm')->name('admin.login-view');

    // Register route for 'user' role
    Route::get('/register', 'registerForm')->name('register-view');
    Route::post('/register', 'register')->name('register');

    // Set password route for 'user' role
    Route::get('/setpassword', 'setPasswordForm')->name('setpassword.view');
    Route::post('setpassword', 'setPassword')->name('setpassword');
  });

  Route::prefix('email')->middleware('auth')->group(function () {
    Route::get('/verify', 'verificationNotice')->name('verification.notice');
    Route::post('/verify/resend', 'resendVerification')->middleware('throttle:5,5')->name('verification.send');
    Route::get('/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
      $request->fulfill();
      $user = $request->user();

      $user->load('role');
      return redirect()->route($user->role->redirect ?? 'user.dashboard');
    })->middleware(['signed', 'auth'])->name('verification.verify');
  });
});
