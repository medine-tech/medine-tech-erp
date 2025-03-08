<?php

use App\Http\Controllers\Backoffice\Users\UserGetController;
use App\Http\Controllers\Backoffice\Users\UserPostController;
use App\Http\Controllers\Backoffice\Users\UserPutController;
use App\Http\Controllers\Backoffice\Users\UsersGetController;
use Illuminate\Support\Facades\Route;

Route::post('/users', UserPostController::class)
    ->name('users.create');

Route::put('/users/{id}', UserPutController::class)
    ->name('users.update');

Route::get('/users/{id}', UserGetController::class)
    ->name('users.show');

Route::get('/users', UsersGetController::class)
    ->name('users.search');

