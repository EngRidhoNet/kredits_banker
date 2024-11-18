<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CreditController;

Route::get('/credits', [CreditController::class, 'index']);
Route::post('/credits/allocate', [CreditController::class, 'allocate'])->name('credits.allocate');
Route::post('/credits/request', [CreditController::class, 'requestCredit'])->name('credits.request');


Route::get('/', function () {
    return view('welcome');
});
