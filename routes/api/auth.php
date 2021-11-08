<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResetPasswordController;

/*
|--------------------------------------------------------------------------
| API Routes for Authentication
|--------------------------------------------------------------------------
*/

Route::post('login', [AuthController::class, 'authenticate']);
Route::post('register', [AuthController::class, 'register']);
Route::post('reset-password', [ResetPasswordController::class, "sendMail"]);
Route::post('change-password', [ResetPasswordController::class, "reset"]);
Route::get('logout', [AuthController::class, 'logout'])
    ->middleware('jwt.verify');
