<?php

use App\Http\Controllers\Backoffice\Companies\CompanyGetController;
use App\Http\Controllers\Backoffice\Companies\CompanyPostController;
use App\Http\Controllers\Backoffice\Companies\CompanyPutController;
use Illuminate\Support\Facades\Route;

Route::post('/companies', CompanyPostController::class)
    ->middleware('auth:sanctum')
    ->name('companies');

Route::put('/companies/{id}', CompanyPutController::class)
    ->middleware('auth:sanctum')
    ->name('companies');

Route::get('/companies/{id}', CompanyGetController::class)
    ->middleware('auth:sanctum')
    ->name('companies');
