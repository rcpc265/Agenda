<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\VisitController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Ruta de las visitas
Route::get('/visits', [VisitController::class, 'index'])->name('visits.index');
Route::get('/visits/create', [VisitController::class, 'create'])->name('visits.create');
Route::get('/visits/{visit}/edit', [VisitController::class, 'edit'])->name('visits.edit');
Route::post('/visits', [VisitController::class, 'store'])->name('visits.store');
