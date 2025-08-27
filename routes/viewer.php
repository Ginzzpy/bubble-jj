<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\ViewerController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:viewer', 'role:viewer,guard=viewer'])->group(function () {
  Route::get('/home', [ViewerController::class, 'index'])->name('viewer.home');
  Route::get('/account', [ViewerController::class, 'account'])->name('viewer.account');
  Route::put('/account', [ViewerController::class, 'update'])->name('viewer.account.put');

  Route::get('/upload/{slug}', [UploadController::class, 'handleView'])->name('viewer.upload');
  Route::post('/order/{menu}', [OrderController::class, 'store'])->name('viewer.order.handle');

  Route::put('/save-password', [AuthController::class, 'savePassword'])->name('save-password');
  Route::post('/verify-password', [AuthController::class, 'verifyPassword'])->name('verify-password');

  Route::prefix('viewer')->name('viewer.')->group(function () {
    Route::delete('/order/{order}', [OrderController::class, 'destroy'])->name('order.destroy');
    Route::get('/order/history', [OrderController::class, 'history'])->name('order.history');
    Route::get('order/{id}', [ViewerController::class, 'show'])->name('order.show');
  });
});
