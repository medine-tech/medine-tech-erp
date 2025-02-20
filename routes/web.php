<?php

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByPath;

//Route::get('/', function () {
//    return ['Laravel' => app()->version()];
//});

//Route::middleware([
//    'web',
//    InitializeTenancyByPath::class,
//    PreventAccessFromCentralDomains::class,
//])->group(function () {
//    Route::get('/ddd', function () {
//        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
//    });
//});


Route::group([
    'prefix' => '{tenant}',
    'middleware' => [
        'web',
        InitializeTenancyByPath::class,
    ],
],

    function () {
        Route::get('/', function () {
            return "Empresa actual: " . tenant('name') . "-" . tenant('id');
        });

//        Route::get('/users', function () {
//            $users = App\Models\User::all();
//            return $users;
//        });
    });
