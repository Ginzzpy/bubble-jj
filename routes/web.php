<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return view('landing');
})->name('landing');

Route::get('/default', function () {
  return redirect()->back();
})->name('login');

require __DIR__ . '/auth.php';
require __DIR__ . '/super.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/viewer.php';
