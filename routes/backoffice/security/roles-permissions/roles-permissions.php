<?php

use App\Http\Controllers\Backoffice\Security\RolesPermissions\UserRolePermissionsController;
use Illuminate\Support\Facades\Route;


Route::post('/roles-permissions/{roleId}/permissions/{permissionId}/attach', [UserRolePermissionsController::class, 'attachPermission'])
    ->name('roles-permissions.permissions.attach');

Route::post('/roles-permissions/{roleId}/permissions/{permissionId}/detach', [UserRolePermissionsController::class, 'detachPermission'])
    ->name('roles-permissions.permissions.detach');
