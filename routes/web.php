<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\User;
use App\Http\Controllers\SuperAdmin;
use App\Http\Controllers\AuthController;

Route::get('/', [User\PasarController::class, 'index']);
Route::get('/pasar', [User\PasarController::class, 'index'])->name('pasar.index');
Route::get('/daftar-pasar', [User\PasarController::class, 'list'])->name('pasar.list');
Route::get('/pasar/{slug}', [User\PasarController::class, 'show'])->name('pasar.show');
Route::get('/artikel', [User\ArtikelController::class, 'index'])->name('artikel.index');
Route::get('/artikel/{id}', [User\ArtikelController::class, 'show'])->name('artikel.show');

Route::post('/ulasan', [User\UlasanController::class, 'store'])->name('ulasan.store')->middleware('throttle:3,1440');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/debug-session', function(Request $request) {
    return [
        'auth_check' => Auth::check(),
        'auth_user' => Auth::user(),
        'session_all' => $request->session()->all()
    ];
});


Route::middleware('auth')->group(function () {

  Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('pasar', Admin\PasarController::class);
    Route::resource('artikel', Admin\ArtikelController::class);
    Route::resource('fasilitas', Admin\FasilitasController::class);
    Route::get('ulasan', [Admin\UlasanController::class, 'index'])->name('ulasan.index');
    Route::patch('ulasan/{ulasan}/approve', [Admin\UlasanController::class, 'approve'])->name('ulasan.approve');
    Route::delete('ulasan/{ulasan}', [Admin\UlasanController::class, 'destroy'])->name('ulasan.destroy');
});

Route::prefix('superadmin')->name('superadmin.')->group(function () {
    Route::resource('pasar', SuperAdmin\PasarController::class);
    Route::resource('artikel', SuperAdmin\ArtikelController::class);
    Route::resource('fasilitas', SuperAdmin\FasilitasController::class);
    Route::resource('admin', SuperAdmin\AdminController::class);
    Route::get('ulasan', [Admin\UlasanController::class, 'index'])->name('ulasan.index');
    Route::patch('ulasan/{ulasan}/approve', [Admin\UlasanController::class, 'approve'])->name('ulasan.approve');
    Route::delete('ulasan/{ulasan}', [Admin\UlasanController::class, 'destroy'])->name('ulasan.destroy');
    });

 });