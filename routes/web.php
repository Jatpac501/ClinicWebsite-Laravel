<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

// Публичные маршруты
Route::get('/', [SearchController::class, 'homepage'])->name('homepage');
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/speciality/{speciality}', [SearchController::class, 'searchBySpeciality'])->name('search.speciality');
Route::get('/doctor/{doctor}', [DoctorController::class, 'index'])->name('doctor.index');
Route::get('/doctor/{doctor}/appointments/booked-times', [AppointmentController::class, 'getBookedTimes'])->name('appointments.booked');

// Маршруты для авторизованных пользователей
Route::middleware('auth')->group(function () {
    // Профиль пользователя
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Записи на приём
    Route::get('/doctor/{doctor}/appointments/{id}', [AppointmentController::class, 'show'])->name('appointments.show');
    Route::post('/doctor/{doctor}/appointments/', [AppointmentController::class, 'store'])->name('appointments.store');

    // Работа с файлами
    Route::get('/appointments/{id}/view-file', [AppointmentController::class, 'viewFile'])->name('appointments.viewFile');
    Route::get('/appointments/{id}/download-file', [AppointmentController::class, 'downloadFile'])->name('appointments.downloadFile');
});

// Маршруты для врачей
Route::middleware(['auth', 'doctor'])->group(function () {
    Route::get('/panel', [PanelController::class, 'index'])->name('doctor.panel');
    Route::post('/doctor/{doctor}/appointments/{id}/uploadFile', [AppointmentController::class, 'uploadFile'])->name('appointments.uploadFile');
    Route::post('/doctor/{doctor}/appointments/{id}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
    Route::post('/doctor/{doctor}/appointments/{id}/complete', [AppointmentController::class, 'complete'])->name('appointments.complete');
});

// Маршруты для администраторов
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/edit', [AdminController::class, 'edit'])->name('admin.edit');
    Route::get('/admin/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/admin/store', [AdminController::class, 'store'])->name('admin.store');
    Route::patch('/admin/update', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin/destroy', [AdminController::class, 'destroy'])->name('admin.destroy');
});

// Маршруты аутентификации
require __DIR__.'/auth.php';