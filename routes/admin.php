<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['role:admin', 'auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/page1', function (Request $request) {
        return spaRender($request, 'pages.tes.page1');
    })->name('page1');

    Route::get('/page2', function (Request $request) {
        return spaRender($request, 'pages.tes.page2');
    })->name('page2');
});
