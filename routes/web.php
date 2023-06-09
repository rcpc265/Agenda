<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SecretaryController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\VisitorController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return redirect()->route('home');
    });

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Ruta de las visitas
    Route::patch('visits/status', [VisitController::class, 'updateStatus'])->name('visits.status');
    Route::resource('visits', VisitController::class);
    Route::post('visits/get', [VisitController::class, 'getVisits'])->name('visits.get');

    // Ruta de las secretarias
    Route::resource('secretaries', SecretaryController::class);
    // Route::get('visits/pdf', [VisitController::class, 'pdf'])->name('visits.pdf');

    Route::get('visit/pdf', [HomeController::class, 'generatePDF'])->name('visits.pdf');

    // Ruta de los visitantes
    Route::resource('visitors', VisitorController::class);
});

Auth::routes();
