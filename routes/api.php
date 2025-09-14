<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GebaeudeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\GebaeudeAdminController;
use App\Http\Controllers\Admin\UserAdminController;

Route::get('/gebaeude', [GebaeudeController::class, 'index']);
Route::get('/gebaeude/{id}', [GebaeudeController::class, 'show']);
Route::get('/gebaeude-in-der-naehe', [GebaeudeController::class, 'gebaeudeInDerNahe']);

Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    // Gebäude bearbeiten (Editor + Admin)
    Route::middleware('RoleMiddleware:editor,admin')->group(function () {
        Route::get('/admin/gebaeude', [GebaeudeAdminController::class, 'index']);
        Route::get('/admin/gebaeude/{id}', [GebaeudeAdminController::class, 'show']);
        Route::put('/admin/gebaeude/{id}', [GebaeudeAdminController::class, 'update']);
    });

    // Benutzerverwaltung (Admin)
    Route::middleware('RoleMiddleware:admin')->group(function () {
        Route::get('/admin/users', [UserAdminController::class, 'index']);
        Route::post('/admin/users', [UserAdminController::class, 'store']);
        Route::post('/admin/users/{id}/role', [UserAdminController::class, 'setRole']);
        Route::delete('/admin/users/{id}', [UserAdminController::class, 'remove']);
    });
});
