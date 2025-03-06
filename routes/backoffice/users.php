<?php

use App\Http\Controllers\Backoffice\Users\UserGetController;
use App\Http\Controllers\Backoffice\Users\UserPostController;
use App\Http\Controllers\Backoffice\Users\UserPutController;
use App\Http\Controllers\Backoffice\Users\UsersGetController;
use Illuminate\Support\Facades\Route;

Route::post('/backoffice/users', UserPostController::class)
    ->middleware('auth:sanctum')
    ->name('users.create');

Route::put('/backoffice/users/{id}', UserPutController::class)
    ->middleware('auth:sanctum')
    ->name('users.update');

Route::get('/backoffice/users/{id}', UserGetController::class)
    ->middleware('auth:sanctum')
    ->name('users.show');

Route::get('/backoffice/users', UsersGetController::class)
    ->middleware('auth:sanctum')
    ->name('users.search');

