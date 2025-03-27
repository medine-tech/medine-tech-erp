<?php

use App\Http\Controllers\Auth\Users\AuthUserGetController;
use Illuminate\Support\Facades\Route;

Route::get('/user', AuthUserGetController::class)
    ->name('auth-users.find');
