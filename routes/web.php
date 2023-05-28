<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SecretaryController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\VisitorController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Ruta de las visitas
Route::patch('visits/status', [VisitController::class, 'updateStatus'])->name('visits.status');
Route::resource('visits', VisitController::class);

// Ruta de las secretarias
Route::resource('secretaries', SecretaryController::class);

// Ruta de los visitantes
Route::resource('visitors', VisitorController::class);
