<?php

use App\Http\Controllers\Auth\Users\AuthUsersGetController;
use Illuminate\Support\Facades\Route;

Route::get('/users', AuthUsersGetController::class)
    ->name('auth-users.search');
