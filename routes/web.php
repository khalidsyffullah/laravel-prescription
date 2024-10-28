<?php


// routes/web.php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\prescriptions\DiagonosisController;
use App\Http\Controllers\users\DashboardController;
use App\Http\Middleware\UserRedirection;

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
Route::post('register', [RegisterController::class, 'register'])->name('register');

// Login routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Authenticated routes with UserRedirection middleware
Route::middleware(['auth', UserRedirection::class])->group(function () {
    Route::get('/doctors/dashboard', function () {
        return view('users.doctors.dashboard');
    })->name('doctor.dashboard');
});



// Protected routes with UserRedirection middleware
Route::middleware(['auth', UserRedirection::class])->group(function () {
    Route::get('/doctors/dashboard', [DashboardController::class, 'index'])->name('doctor.dashboard');
    Route::get('/diagonosis', [DiagonosisController::class, 'index'])->name('diagonosis.index');
    Route::post('/diagonosis', [DiagonosisController::class, 'store'])->name('diagonosis.store');
});
