<?php

use App\Http\Controllers\Backoffice\Accounting\AccountingAccounts\AccountingAccountGetController;
use App\Http\Controllers\Backoffice\Accounting\AccountingAccounts\AccountingAccountPostController;
use App\Http\Controllers\Backoffice\Accounting\AccountingAccounts\AccountingAccountPutController;
use App\Http\Controllers\Backoffice\Accounting\AccountingAccounts\AccountingAccountsGetController;
use Illuminate\Support\Facades\Route;

Route::post('/accounting-accounts', AccountingAccountPostController::class)
    ->name('accounting-accounts.create');

Route::put('/accounting-accounts/{id}', AccountingAccountPutController::class)
    ->name('accounting-accounts.update');

Route::get('/accounting-accounts/{id}', AccountingAccountGetController::class)
    ->name('accounting-accounts.get');

Route::get('/accounting-accounts', AccountingAccountsGetController::class)
    ->name('accounting-accounts.search');
