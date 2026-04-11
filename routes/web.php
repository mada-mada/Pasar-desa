<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\User;
use App\Http\Controllers\SuperAdmin;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pasar', [User\PasarController::class, 'index'])->name('pasar.index');
Route::get('/pasar/{slug}', [User\PasarController::class, 'show'])->name('pasar.show');
Route::get('/artikel', [User\ArtikelController::class, 'index'])->name('artikel.index');


Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

  Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('pasar', Admin\PasarController::class);
    Route::resource('artikel', Admin\ArtikelController::class);
    Route::resource('fasilitas', Admin\FasilitasController::class);
});

Route::prefix('superadmin')->name('superadmin.')->group(function () {
    Route::resource('pasar', SuperAdmin\PasarController::class);
    Route::resource('artikel', SuperAdmin\ArtikelController::class);
    Route::resource('fasilitas', SuperAdmin\FasilitasController::class);
});

});