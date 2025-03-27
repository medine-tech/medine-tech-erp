<?php

use App\Http\Controllers\Auth\Companies\AuthCompaniesGetController;
use Illuminate\Support\Facades\Route;

Route::get('/companies', AuthCompaniesGetController::class)
    ->name('auth-companies.search');
