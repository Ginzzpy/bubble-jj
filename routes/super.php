<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::middleware(['auth', 'role:super,guard=admin'])->group(function () {
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('super.dashboard');
});
