<?php

use App\Http\Controllers\Backoffice\Accounting\AccountingCenterPostController;
use Illuminate\Support\Facades\Route;

Route::post('/accounting-centers', AccountingCenterPostController::class)
    ->name('accounting-centers.create');
