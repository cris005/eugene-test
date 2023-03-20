<?php

use App\Http\Controllers\ClinicController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\TestController;

Route::get('/', function() {
    return redirect()->route('doctors.index');
});

Route::get('/doctors/{doctor:ulid}/merge/{duplicate_doctor:ulid}', [DoctorController::class, 'merge'])
    ->name('doctors.merge');
Route::get('/clinics/{clinic:ulid}/merge/{duplicate_clinic:ulid}', [ClinicController::class, 'merge'])
    ->name('clinics.merge');

Route::post('/doctors/{doctor:ulid}/merge/{duplicate_doctor:ulid}', [DoctorController::class, 'combine'])
    ->name('doctors.combine');
Route::post('/clinics/{clinic:ulid}/merge/{duplicate_clinic:ulid}', [ClinicController::class, 'combine'])
    ->name('clinics.combine');

Route::resource('doctors', DoctorController::class);
Route::resource('tests', TestController::class);
Route::resource('clinics', ClinicController::class);
