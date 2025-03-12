<?php

use App\Http\Controllers\Backoffice\Accounting\AccountingCenter\AccountingCenterPostController;
use Illuminate\Support\Facades\Route;

Route::post('/accounting-centers', AccountingCenterPostController::class)
    ->name('backoffice.accounting-centers.create');
