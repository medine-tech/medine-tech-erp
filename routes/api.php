<?php

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByPath;

require __DIR__ . '/auth.php';
require __DIR__ . '/backoffice/first-companies.php';

Route::group([
    'prefix' => 'backoffice/{tenant}',
    'middleware' => [
        'auth:sanctum',
        InitializeTenancyByPath::class,
    ],
], function () {
    require __DIR__ . '/backoffice/companies.php';
    require __DIR__ . '/backoffice/users.php';
    require __DIR__ . '/backoffice/accounting-centers.php';
});
