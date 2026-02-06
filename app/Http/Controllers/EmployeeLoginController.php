<?php

use App\Http\Controllers\Auth\EmployeeLoginController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

// Rutas de autenticación para usuarios normales
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rutas de autenticación para empleados
Route::prefix('employee')->group(function () {
    Route::get('/login', [EmployeeLoginController::class, 'showLoginForm'])->name('employee.login');
    Route::post('/login', [EmployeeLoginController::class, 'login']);
    Route::post('/logout', [EmployeeLoginController::class, 'logout'])->name('employee.logout');
});
