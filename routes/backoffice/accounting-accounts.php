<?php

use App\Http\Controllers\Backoffice\Accounting\AccountingAccounts\AccountingAccountPostController;
use Illuminate\Support\Facades\Route;

Route::post('/accounting-accounts', AccountingAccountPostController::class)
    ->name('accounting-accounts.create');
