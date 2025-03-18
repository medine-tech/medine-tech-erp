<?php

use App\Http\Controllers\Backoffice\Security\RolePermissions\RolePermissionPostController;
use App\Http\Controllers\Backoffice\Security\RolePermissions\RolePermissionDeleteController;
use Illuminate\Support\Facades\Route;


Route::post('/role-permissions', RolePermissionPostController::class)
    ->name('role-permissions');

Route::delete('/role-permissions', RolePermissionDeleteController::class)
    ->name('role-permissions');
