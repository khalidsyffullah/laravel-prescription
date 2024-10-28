<?php


// routes/web.php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\prescriptions\DiagonosisController;
use App\Http\Controllers\prescriptions\PrescriptionController;
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
    Route::get('/prescriptions', [PrescriptionController::class, 'index'])->name('prescription.index');
    Route::get('/prescriptions', [PrescriptionController::class, 'index'])->name('prescription.index');
    Route::get('/prescriptions/search', [PrescriptionController::class, 'search'])->name('prescription.search'); // New search route
    Route::post('/prescriptions', [PrescriptionController::class, 'store'])->name('prescription.store'); // New store route for creating a new diagnosis

    route::post('/prescription/save-session', [PrescriptionController::class, 'saveSession'])->name('prescription.saveSession');
    Route::get('/prescription/preview', [PrescriptionController::class, 'preview'])->name('prescription.preview');
});
