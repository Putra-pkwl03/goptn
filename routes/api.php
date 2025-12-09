<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\StudentAuthController;
use App\Http\Controllers\StudentSetupController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\JadwalAdmissionController;

Route::post('auth/admin/login', [AdminAuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('auth/admin/logout', [AdminAuthController::class, 'logout']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/admin/students', [AdminAuthController::class, 'listStudents']);
    Route::get('/admin/student/{id}', [AdminAuthController::class, 'showStudent']);
    Route::delete('/admin/student/{id}', [AdminAuthController::class, 'deleteStudent']);
});

Route::post('auth/student/register', [StudentAuthController::class, 'register']);
Route::post('auth/student/login', [StudentAuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/student/me', [StudentAuthController::class, 'me']);
    Route::put('/student/update', [StudentAuthController::class, 'update']);
    Route::patch('/student/notification-toggle', [StudentAuthController::class, 'toggleNotification']);
    Route::post('auth/student/logout', [StudentAuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/student/setup', [StudentSetupController::class, 'setup']);
    Route::put('/student/update', [StudentSetupController::class, 'update']);
    Route::delete('/student/setup/delete', [StudentSetupController::class, 'destroy']);
});


// Public routes (tidak perlu login)
Route::get('/campus', [CampusController::class, 'index']);
Route::get('/campus/{id}', [CampusController::class, 'show']);
Route::get('/major', [MajorController::class, 'index']);
Route::get('/major/{id}', [MajorController::class, 'show']);

// Admin routes (CRUD lengkap, harus login)
Route::middleware(['auth:sanctum'])->prefix('admin')->group(function () {
    // Kampus
    Route::post('/campus', [CampusController::class, 'store']);
    Route::put('/campus/{id}', [CampusController::class, 'update']);
    Route::delete('/campus/{id}', [CampusController::class, 'destroy']);

    // Jurusan
    Route::post('/major', [MajorController::class, 'store']);
    Route::put('/major/{id}', [MajorController::class, 'update']);
    Route::delete('/major/{id}', [MajorController::class, 'destroy']);

    #Jadwal CRUD
    Route::get('/admisi', [JadwalAdmissionController::class, 'index']);
    Route::post('/admisi', [JadwalAdmissionController::class, 'store']);
    Route::get('/admisi/{id}', [JadwalAdmissionController::class, 'show']);
    Route::put('/admisi/{id}', [JadwalAdmissionController::class, 'update']);
    Route::delete('/admisi/{id}', [JadwalAdmissionController::class, 'destroy']);

});

