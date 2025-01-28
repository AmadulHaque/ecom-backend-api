<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::get('/admin/login', [AuthController::class, 'login'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'loginPost'])->name('admin.login.post');
});

Route::middleware(['auth'])->group(function () {
    // logout
    Route::get('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');
});
