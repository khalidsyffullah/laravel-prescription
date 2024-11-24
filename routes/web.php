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
use App\Http\Controllers\testController;
use App\Http\Controllers\prescriptions\prescriptionSessionController;

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
    // Route::get('/', [testController::class, 'index'])->name('home');
    Route::get('/prescriptions', [PrescriptionController::class, 'index'])->name('prescription.index');

    Route::post('/additional-advice/search', [PrescriptionController::class, 'additionalAdviceSearch'])->name('additionalAdvice.search');
    Route::post('/additional-advice/store', [PrescriptionController::class, 'additionalAdviceStore'])->name('additionalAdvice.store');

    Route::post('/advice-test/search', [PrescriptionController::class, 'adviceTestSearch'])->name('adviceTest.search');
    Route::post('/advice-test/store', [PrescriptionController::class, 'adviceTestStore'])->name('adviceTest.store');

    Route::post('/advice-investigation/search', [PrescriptionController::class, 'adviceInvestigationSearch'])->name('adviceInvestigation.search');
    Route::post('/advice-investigation/store', [PrescriptionController::class, 'adviceInvestigationStore'])->name('adviceInvestigation.store');

    Route::post('/diagnosis/search', [PrescriptionController::class, 'diagonosisSearch'])->name('diagnosis.search');
    Route::post('/diagnosis/store', [PrescriptionController::class, 'diagonosisStore'])->name('diagnosis.store');

    Route::post('/drug/search', [PrescriptionController::class, 'drugSearch'])->name('drug.search');
    Route::post('/drug/store', [PrescriptionController::class, 'drugStore'])->name('drug.store');

    Route::post('/additional-advice-store-selection', [prescriptionSessionController::class, 'storeAdditionalAdviceSelectionInSession'])->name('additionalAdvice.store.selection');
    Route::post('/additional-advice-remove-selection', [prescriptionSessionController::class, 'removeAdditionalAdviceSelection'])->name('additionalAdvice.remove.selection');
    route::post('/check-additional-advice-session', [prescriptionSessionController::class, 'checkAdditionalAdviceInSession'])->name('additionalAdvice.checkSession');

    Route::post('/advice-test-store-selection', [prescriptionSessionController::class, 'storeAdviceTestsSelectionInSession'])->name('adviceTest.store.selection');
    Route::post('/advice-test-remove-selection', [prescriptionSessionController::class, 'removeAdviceTestsSelection'])->name('adviceTest.remove.selection');
    route::post('/check-advice-test-session', [prescriptionSessionController::class, 'checkAdviceTestInSession'])->name('adviceTest.checkSession');

    Route::post('/advice-investigation-store-selection', [prescriptionSessionController::class, 'storeAdviceInvestigationSelectionInSession'])->name('adviceInvestigation.store.selection');
    Route::post('/advice-investigation-remove-selection', [prescriptionSessionController::class, 'removeAdviceInvestigationSelectionFromSession'])->name('adviceInvestigation.remove.selection');
    route::post('/check-advice-investigation-session', [prescriptionSessionController::class, 'checkAdviceInvestigationInSession'])->name('adviceInvestigation.checkSession');

    Route::post('/diagnosis-store-selection', [prescriptionSessionController::class, 'storeDiagonosisSelectionInSession'])->name('diagnosis.store.selection');
    Route::post('/diagnosis-remove-selection', [prescriptionSessionController::class, 'removeDiagonosisSelection'])->name('diagnosis.remove.selection');
    route::post('/check-diagnosis-session', [prescriptionSessionController::class, 'checkDiagnosisInSession'])->name('diagnosis.checkSession');

    Route::post('/drug-store-selection', [prescriptionSessionController::class, 'storeDrugSelectionInSession'])->name('drug.store.selection');
    Route::post('/drug-remove-selection', [prescriptionSessionController::class, 'removeDrugSelectionFromSession'])->name('drug.remove.selection');
    route::post('/check-drug-session', [prescriptionSessionController::class, 'checkDrugInSession'])->name('drug.checkSession');

    Route::get('/doctors/dashboard', [DashboardController::class, 'index'])->name('doctor.dashboard');
    Route::get('/diagonosis', [DiagonosisController::class, 'index'])->name('diagonosis.index');
    Route::post('/diagonosis', [DiagonosisController::class, 'store'])->name('diagonosis.store');

    Route::get('advice-investigation', [Advice_investigationsController::class, 'index'])->name('prescription.adviceInvestigation');
    Route::post('/advice-investigation', [Advice_investigationsController::class, 'store'])->name('advice_investigation.store');
    Route::get('/additional-advices', [additional_adviceController::class, 'index'])->name('additional_advice.index');
    Route::POST('/additional-advices', [additional_adviceController::class, 'store'])->name('additional_advice.store');
    Route::get('/drugs', [DrugController::class, 'index'])->name('drug.view');
    Route::POST('/drugs', [DrugController::class, 'store'])->name('drugs.store');
    Route::get('/adviced-tests', [Advice_testsController::class, 'index'])->name('tests');
    Route::POST('/adviced-tests', [Advice_testsController::class, 'store'])->name('tests.store');
    Route::get('/patients', [patientDetailsController::class, 'index'])->name('patients');
    Route::post('/patients', [patientDetailsController::class, 'store'])->name('patient.store');
    Route::post('/check-patient', [patientDetailsController::class, 'checkPatient'])->name('check.patient');
    Route::post('/patient/update', [patientDetailsController::class, 'update'])->name('patient.update');
});
