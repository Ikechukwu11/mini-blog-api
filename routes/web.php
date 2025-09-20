<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\PostController;
use App\Http\Controllers\Web\DashboardController;

Route::get('/', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::get('/posts/create', [DashboardController::class, 'create'])->name('dashboard.posts.create');
        Route::post('/posts', [DashboardController::class, 'store'])->name('dashboard.posts.store');
        Route::get('/posts/{post}/edit', [DashboardController::class, 'edit'])->name('dashboard.posts.edit');
        Route::put('/posts/{post}', [DashboardController::class, 'update'])->name('dashboard.posts.update');
        Route::delete('/posts/{post}', [DashboardController::class, 'destroy'])->name('dashboard.posts.destroy');
    });
});
