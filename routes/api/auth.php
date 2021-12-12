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
Route::post('reset-password-request', [ResetPasswordController::class, 'send_mail_reset_password']);
Route::post('reset-password', [ResetPasswordController::class, 'reset_password']);
Route::post('change-password', [ResetPasswordController::class, 'change_password'])
    ->middleware('jwt.verify');
Route::get('jwt-validate', [AuthController::class, 'jwtValidate'])
    ->middleware('jwt.verify');
