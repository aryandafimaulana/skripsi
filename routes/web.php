<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataIndikatorController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataUploadController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [DataIndikatorController::class, 'dataCard'])->name('home');

Route::get('/maps', [MapController::class, 'index'])->name('maps');

Route::get('/data', [DataIndikatorController::class, 'index'])->name('data.index');

Route::get('/data', [DataIndikatorController::class, 'dataTable']);

Route::get('/export-excel', [\App\Http\Controllers\ExportController::class, 'exportExcel'])->name('export.excel');
Route::post('/data/import', [DataUploadController::class, 'import'])->name('data.import');

Route::get('/hasil-analisis', function () {
    return view('hasilAnalisis');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/kelolaData', [DataIndikatorController::class, 'kelola'])->name('data.kelola');
    Route::post('/kelolaData', [DataIndikatorController::class, 'store'])->name('data.store');
    Route::put('/kelolaData/{id}', [DataIndikatorController::class, 'update'])->name('data.update');
    Route::delete('/kelolaData/{id}', [DataIndikatorController::class, 'destroy'])->name('data.destroy');
});


Route::get('/map/geojson', [MapController::class, 'getGeoJson']);
