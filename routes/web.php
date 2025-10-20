<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\DischargeController;
use App\Http\Controllers\VisitPasscodeController;
use App\Http\Controllers\WardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VisitorController;


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/visitor', [VisitorController::class, 'index'])->name('visitor');
Route::get('/visitor/search', [VisitorController::class, 'search'])->name('visitor.search');

Route::middleware(['auth'])->group(function () {
    Route::get('/',[DashboardController::class,'index'])->name('dashboard');

    Route::get('/admission',[AdmissionController::class,'form'])->name('admission.form');
    Route::post('/admission',[AdmissionController::class,'store'])->name('admission.store');

    Route::get('/discharge',[DischargeController::class,'form'])->name('discharge.form');
    Route::get('/discharge/search',[DischargeController::class,'search'])->name('discharge.search');
    Route::post('/discharge/{patient}/complete',[DischargeController::class,'complete'])->name('discharge.complete');

    Route::get('/passcode',[VisitPasscodeController::class,'index'])->name('passcode.index');
    Route::get('/passcode/search',[VisitPasscodeController::class,'search'])->name('passcode.search');
    Route::post('/passcode/{patient}/generate',[VisitPasscodeController::class,'generate'])->name('passcode.generate');
    Route::post('/passcode/{patient}/invalidate',[VisitPasscodeController::class,'invalidate'])->name('passcode.invalidate');

    Route::get('/admin/wards',[WardController::class,'index'])->name('admin.wards');
    Route::post('/admin/wards',[WardController::class,'store'])->name('admin.wards.store');
    Route::delete('/admin/wards/{ward}',[WardController::class,'destroy'])->name('admin.wards.destroy');
    Route::put('/admin/wards/{ward}',[WardController::class,'update'])->name('admin.wards.update');
});






