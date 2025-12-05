<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\StudentAuthController;
use App\Http\Controllers\StudentSetupController;

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
    Route::post('auth/student/logout', [StudentAuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/student/setup', [StudentSetupController::class, 'setup']);
    Route::put('/student/update', [StudentSetupController::class, 'update']);
    Route::delete('/student/setup/delete', [StudentSetupController::class, 'destroy']);
});
