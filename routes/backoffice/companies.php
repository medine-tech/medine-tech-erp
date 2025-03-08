<?php

use App\Http\Controllers\Backoffice\Companies\CompaniesGetController;
use App\Http\Controllers\Backoffice\Companies\CompanyGetController;
use App\Http\Controllers\Backoffice\Companies\CompanyPostController;
use App\Http\Controllers\Backoffice\Companies\CompanyPutController;
use Illuminate\Support\Facades\Route;

Route::get('/companies', CompaniesGetController::class)
    ->name('companies.search');

Route::post('/companies', CompanyPostController::class)
    ->name('companies.create');

Route::put('/companies/{id}', CompanyPutController::class)
    ->name('companies.update');

Route::get('/companies/{id}', CompanyGetController::class)
    ->name('companies.show');
