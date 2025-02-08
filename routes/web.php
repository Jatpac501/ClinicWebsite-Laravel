<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SearchController::class, 'homepage'])->name('homepage');
Route::get('/speciality/{speciality}', [SearchController::class, 'searchBySpeciality'])->name('search.speciality');
Route::get('/doctor/{id}', [DoctorController::class, 'index'])->name('doctor.index');

Route::get('/doctor/{doctor}/appointments/booked-times', [AppointmentController::class,'getBookedTimes'])->name('appointments.booked');
Route::post('/doctor/{doctor}/appointments/', [AppointmentController::class,'store'])->name('appointments.store');