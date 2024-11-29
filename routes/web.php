<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Admin\LoginController as loginAdminController;
use App\Http\Controllers\Admin\AdminController as AdminController;

Route::get('/', function () {
    return view('welcome');
});
Route::prefix('admin')->group(function () {
    // Redirect To Login
    Route::get('/', function () {
        return redirect()->route('admin.login');
    });

    Route::get('/login', [loginAdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [loginAdminController::class, 'login']);
    Route::post('/logout', [loginAdminController::class, 'logout'])->name('admin.logout');

    // After Login
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    });
});
