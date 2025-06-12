<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataIndikatorController;
use App\Http\Controllers\MapController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/homepage', [DataIndikatorController::class, 'dataCard'])->name('data.dataCard');

Route::get('/maps', [MapController::class, 'index'])->name('maps');

Route::get('/data', [DataIndikatorController::class, 'index'])->name('data.index');

Route::get('/login', function () {
    return view('login');
});
