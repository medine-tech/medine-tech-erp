<?php

use App\Http\Controllers\Backoffice\FirstCompanies\FirstCompanyPostController;
use Illuminate\Support\Facades\Route;

Route::post('/backoffice/first-companies', FirstCompanyPostController::class)
    ->middleware('guest')
    ->name('register');
