<?php


// routes/web.php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\patientDetailsController;
use App\Http\Controllers\prescriptions\additional_adviceController;
use App\Http\Controllers\prescriptions\DiagonosisController;
use App\Http\Controllers\prescriptions\PrescriptionController;
use App\Http\Controllers\users\DashboardController;
use App\Http\Middleware\UserRedirection;
use App\Http\Controllers\prescriptions\Advice_investigationsController;
use App\Http\Controllers\prescriptions\Advice_testsController;
use App\Http\Controllers\prescriptions\DrugController;

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
    Route::get('/prescriptions/search-diagonosis', [PrescriptionController::class, 'searchDiagonosis'])->name('prescription.searchDiagonosis');
    Route::get('/prescriptions/search-additional-advice', [PrescriptionController::class, 'searchAdditionalAdvice'])->name('prescription.searchAdditionalAdvice');

    route::post('/prescription/save-session', [PrescriptionController::class, 'saveSession'])->name('prescription.saveSession');
    Route::get('/prescription/preview', [PrescriptionController::class, 'preview'])->name('prescription.preview');
    Route::get('advice-investigation',[Advice_investigationsController::class, 'index'])->name('prescription.adviceInvestigation');
    Route::post('/advice-investigation', [Advice_investigationsController::class,'store'])->name('advice_investigation.store');
    Route::get('/additional-advices', [additional_adviceController::class, 'index'])->name('additional_advice.index');
    Route:: POST('/additional-advices',[additional_adviceController::class, 'store'])->name('additional_advice.store');
    Route::get('/drugs',[DrugController::class, 'index'])->name('drug.view');
    Route::POST('/drugs',[DrugController::class, 'store'])->name('drugs.store');
    Route::get('/adviced-tests', [Advice_testsController::class,'index'] ) ->name('tests');
    Route::POST('/adviced-tests',[Advice_testsController::class, 'store'])->name('tests.store');
    Route::get('/patients', [patientDetailsController::class, 'index'])->name('patients');
    Route::post('/patients', [patientDetailsController::class, 'store'])->name('patient.store');
    Route::post('/check-patient', [patientDetailsController::class, 'checkPatient'])->name('check.patient');
    Route::post('/patient/update', [patientDetailsController::class, 'update'])->name('patient.update');

});
