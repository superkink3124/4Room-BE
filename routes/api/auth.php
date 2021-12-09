<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResetPasswordController;

/*
|--------------------------------------------------------------------------
| API Routes for Authentication
|--------------------------------------------------------------------------
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'authenticate']);
Route::get('logout', [AuthController::class, 'logout'])
    ->middleware('jwt.verify');
Route::post('reset-password-request', [ResetPasswordController::class, 'sendMail']);
Route::post('reset-password', [ResetPasswordController::class, 'reset']);
Route::get('jwt-validate', [AuthController::class, 'jwtValidate'])
    ->middleware('jwt.verify');
