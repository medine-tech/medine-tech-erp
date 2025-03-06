<?php

use App\Http\Controllers\Backoffice\Companies\CompaniesGetController;
use App\Http\Controllers\Backoffice\Companies\CompanyGetController;
use App\Http\Controllers\Backoffice\Companies\CompanyPostController;
use App\Http\Controllers\Backoffice\Companies\CompanyPutController;
use Illuminate\Support\Facades\Route;

Route::get('/backoffice/companies', CompaniesGetController::class)
    ->middleware('auth:sanctum')
    ->name('companies.search');

Route::post('/backoffice/companies', CompanyPostController::class)
    ->middleware('auth:sanctum')
    ->name('companies.create');

Route::put('/backoffice/companies/{id}', CompanyPutController::class)
    ->middleware('auth:sanctum')
    ->name('companies.update');

Route::get('/backoffice/companies/{id}', CompanyGetController::class)
    ->middleware('auth:sanctum')
    ->name('companies.show');
