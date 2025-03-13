<?php

use App\Http\Controllers\Backoffice\Accounting\AccountingCenters\AccountingCenterGetController;
use App\Http\Controllers\Backoffice\Accounting\AccountingCenters\AccountingCenterPostController;
use App\Http\Controllers\Backoffice\Accounting\AccountingCenters\AccountingCenterPutController;
use App\Http\Controllers\Backoffice\Accounting\AccountingCenters\AccountingCentersGetController;
use Illuminate\Support\Facades\Route;

Route::post('/accounting-centers', AccountingCenterPostController::class)
    ->name('backoffice.accounting-centers.create');

Route::get('/accounting-centers/{id}', AccountingCenterGetController::class)
    ->name('backoffice.accounting-centers.find');

Route::get('/accounting-centers', AccountingCentersGetController::class)
    ->name('backoffice.accounting-centers.search');

Route::put('/accounting-centers/{id}', AccountingCenterPutController::class)
    ->name('backoffice.accounting-centers.update');
