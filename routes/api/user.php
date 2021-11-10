<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes for User
|--------------------------------------------------------------------------
*/


Route::get('users', [UserController::class, "index"]);
Route::get('users/{id}', [UserController::class, "show"])
    ->middleware('jwt.verify');
Route::post('profile', [UserController::class, "update"])
    ->middleware('jwt.verify');
Route::post('users/search', [UserController::class, "search"])
    ->middleware('jwt.verify');
