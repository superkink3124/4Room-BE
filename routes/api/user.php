<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes for User
|--------------------------------------------------------------------------
*/


Route::get('users', [UserController::class, "index"])
    ->middleware('jwt.verify');
Route::get('users/search', [UserController::class, "search"])
    ->middleware('jwt.verify');
Route::get('users/{id}', [UserController::class, "show"])
    ->middleware('jwt.verify');
Route::post('profile', [UserController::class, "update"])
    ->middleware('jwt.verify');
Route::get('profile', [UserController::class, "getProfile"])
    ->middleware('jwt.verify');
Route::post('change_avatar', [UserController::class, "change_avatar"])
    ->middleware('jwt.verify');
