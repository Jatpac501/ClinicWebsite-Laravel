<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SearchController::class, 'homepage'])->name('homepage');
Route::get('/speciality/{speciality}', [SearchController::class, 'searchBySpeciality'])->name('search.speciality');
Route::get('/doctor/{doctor}', [DoctorController::class, 'index'])->name('doctor.index');

Route::get('/doctor/{doctor}/appointments/booked-times', [AppointmentController::class,'getBookedTimes'])->name('appointments.booked');
Route::post('/doctor/{doctor}/appointments/', [AppointmentController::class,'store'])->name('appointments.store');

Route::get('/search', [SearchController::class,'search'])->name('search');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
