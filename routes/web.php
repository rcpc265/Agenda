<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\VisitaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Ruta de las visitas
Route::get('/visitas', [VisitaController::class, 'index'])->name('visitas.index');
Route::get('/visitas/create', [VisitaController::class, 'create'])->name('visitas.create');
Route::get('/visitas/{visita}/edit', [VisitaController::class, 'edit'])->name('visitas.edit');
Route::post('/visitas', [VisitaController::class, 'store'])->name('visitas.store');
