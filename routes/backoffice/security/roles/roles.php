<?php

use App\Http\Controllers\Backoffice\Security\Roles\RoleGetController;
use App\Http\Controllers\Backoffice\Security\Roles\RolePostController;
use App\Http\Controllers\Backoffice\Security\Roles\RolePutController;
use App\Http\Controllers\Backoffice\Security\Roles\RolesGetController;
use Illuminate\Support\Facades\Route;

Route::post('/roles', RolePostController::class)
    ->name('roles.create');

Route::get('/roles/{id}', RoleGetController::class)
    ->name('roles.show');

Route::get('/roles', RolesGetController::class)
    ->name('roles.search');

Route::put('/roles/{id}', RolePutController::class)
    ->name('roles.update');
