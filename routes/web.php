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
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    Route::post('/appointments/{id}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');

    // Записи на приём
    Route::get('/doctor/{doctor}/appointments/{id}', [AppointmentController::class, 'show'])->name('appointments.show');
    Route::post('/doctor/{doctor}/appointments/', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointment', [AppointmentController::class, 'panel'])->name('appointment.panel');

    // Работа с файлами
    Route::prefix('appointments/{id}')->name('appointments.')->group(function () {
        Route::get('/view-file', [AppointmentController::class, 'viewFile'])->name('viewFile');
        Route::get('/download-file', [AppointmentController::class, 'downloadFile'])->name('downloadFile');
    });
});

// Маршруты для врачей
Route::middleware(['auth', 'doctor'])->group(function () {
    Route::prefix('doctor/{doctor}/appointments/{id}')->name('appointments.')->group(function () {
        Route::post('/uploadFile', [AppointmentController::class, 'uploadFile'])->name('uploadFile');
        Route::post('/complete', [AppointmentController::class, 'complete'])->name('complete');
    });

    // Панель врача
    Route::get('/panel', [PanelController::class, 'index'])->name('doctor.panel');
});

// Маршруты для администраторов
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/edit', [AdminController::class, 'edit'])->name('admin.edit');
    Route::get('/admin/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/admin/store', [AdminController::class, 'store'])->name('admin.store');
    Route::patch('/admin/update/{doctor}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin/destroy/{doctor}', [AdminController::class, 'destroy'])->name('admin.destroy');
});


// Маршруты аутентификации
require __DIR__.'/auth.php';
