<?php

use App\Http\Controllers\Backoffice\Security\Roles\RolePostController;
use Illuminate\Support\Facades\Route;

Route::post('/roles', RolePostController::class)
    ->name('roles.create');
