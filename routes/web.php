<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\User;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pasar', [User\PasarController::class, 'index'])->name('pasar.index');
Route::get('/pasar/{slug}', [User\PasarController::class, 'show'])->name('pasar.show');
Route::get('/artikel', [User\ArtikelController::class, 'index'])->name('artikel.index');