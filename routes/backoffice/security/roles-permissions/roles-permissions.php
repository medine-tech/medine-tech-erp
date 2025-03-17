<?php

use App\Http\Controllers\Backoffice\Security\RolesPermissions\UserRolePermissionsController;
use Illuminate\Support\Facades\Route;


Route::post('/roles-permissions/permissions/attach', [UserRolePermissionsController::class, 'attachPermission'])
    ->name('roles-permissions.permissions.attach');

Route::post('/roles-permissions/permissions/detach', [UserRolePermissionsController::class, 'detachPermission'])
    ->name('roles-permissions.permissions.detach');
