<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\PasarController;
use App\Http\Controllers\Admin\ArtikelController;
use App\Http\Controllers\Admin\FasilitasController;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/users', [UserController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    
    // Route mendapatkan data user yang sedang login
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::apiResource('pasar', PasarController::class);
        Route::apiResource('artikel', ArtikelController::class);
        Route::apiResource('fasilitas', FasilitasController::class);
    });

});