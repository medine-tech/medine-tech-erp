<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Stancl\Tenancy\Middleware\InitializeTenancyByPath;


/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::group([
    'prefix' => '{company}',
    'middleware' => [
        'web',
        InitializeTenancyByPath::class,
    ],
],

    function () {
        Route::get('/', function () {
            return "Empresa actual: " . tenant('name');
        });

    Route::get('/users', function () {
        $users = App\Models\User::all();
        return $users;
    });
});


