<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ModeratorController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::group(['middleware' => 'role:admin'], function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/admin', [AdminController::class, 'store'])->name('admin.store');
    Route::delete('/admin/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
});

Route::group(['middleware' => 'role:moderator'], function () {
    Route::get('/moderator', [ModeratorController::class, 'index'])->name('moderator.index');
    Route::post('/moderator', [ModeratorController::class, 'store'])->name('moderator.store');
    Route::delete('/moderator/{id}', [ModeratorController::class, 'destroy'])->name('moderator.destroy');
});

Route::group(['middleware' => 'role:user'], function () {
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
});
