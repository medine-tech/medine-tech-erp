<?php

use App\Http\Middleware\TeamsPermission;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByPath;

require __DIR__ . '/auth.php';
require __DIR__ . '/backoffice/first-companies.php';

Route::group([
    'prefix' => 'backoffice/{tenant}',
    'middleware' => [
        'auth:sanctum',
        InitializeTenancyByPath::class,
        TeamsPermission::class,
    ],
], function () {
    require __DIR__ . '/backoffice/companies.php';
    require __DIR__ . '/backoffice/users.php';
});

Route::group([
    'prefix' => 'backoffice/{tenant}/accounting',
    'middleware' => [
        'auth:sanctum',
        InitializeTenancyByPath::class,
        TeamsPermission::class,
    ],
], function () {
    require __DIR__ . '/backoffice/accounting/accounting-accounts/accounting-accounts.php';
    require __DIR__ . '/backoffice/accounting/accounting-center/accounting-centers.php';
});

Route::group([
    'prefix' => 'backoffice/{tenant}/security',
    'middleware' => [
        'auth:sanctum',
        InitializeTenancyByPath::class,
        TeamsPermission::class,
    ],
], function () {
    require __DIR__ . '/backoffice/security/roles/roles.php';
    require __DIR__ . '/backoffice/security/roles-permissions/roles-permissions.php';
});
