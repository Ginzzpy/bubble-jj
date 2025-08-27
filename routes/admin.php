<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JJController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UploadController;

Route::middleware('auth:admin')->group(function () {
  Route::middleware('role:super,admin,guard=admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/order/{order}/upload-result', [UploadController::class, 'handleUpload'])->name('upload.result');

    Route::prefix('admin')->name('admin.')->group(function () {
      Route::post('/order/{order}/reject', [OrderController::class, 'reject'])->name('order.reject');
      Route::delete('/order/{order}', [OrderController::class, 'destroy'])->name('order.destroy');
      Route::get('/order/history', [OrderController::class, 'history'])->name('order.history');
    });
    Route::resource('order', OrderController::class);

    Route::get('/data-jj', [JJController::class, 'index'])->name('data.jj');
  });

  // Role super only
  Route::middleware('role:super,guard=admin')->group(function () {
    Route::resource('admin', AdminController::class);
  });
});
