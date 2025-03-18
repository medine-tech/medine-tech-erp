<?php

use App\Http\Controllers\Backoffice\Security\RolePermissions\RolePermissionAttachPostController;
use App\Http\Controllers\Backoffice\Security\RolePermissions\RolePermissionDetachDeleteController;
use Illuminate\Support\Facades\Route;


Route::post('/role-permissions/attach', RolePermissionAttachPostController::class)
    ->name('role-permissions.permissions.attach');

Route::DELETE('/role-permissions/detach', RolePermissionDetachDeleteController::class)
    ->name('role-permissions.permissions.detach');
