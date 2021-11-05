<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

Route::post('login', [AuthController::class, 'authenticate']);
Route::post('register', [AuthController::class, 'register']);

Route::get('users/{id}', [UserController::class, 'show']);
Route::post('users', [UserController::class, 'store']);

Route::delete('users/{id}', [UserController::class, 'destroy']);

Route::get('users/search/{name}', [UserController::class, 'search']);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('get_user', [AuthController::class, 'get_user']);
    Route::get('create_post', [PostController::class, "create_post"]);
    Route::get('delete_post', [PostController::class, "delete_post"]);
    Route::post('profile', [UserController::class, 'update']);
    // Route::get('products', [ProductController::class, 'index']);
    // Route::get('products/{id}', [ProductController::class, 'show']);
    // Route::post('create', [ProductController::class, 'store']);
    // Route::put('update/{product}',  [ProductController::class, 'update']);
    // Route::delete('delete/{product}',  [ProductController::class, 'destroy']);
});
use App\Http\Controllers\ResetPasswordController;

Route::post('reset-password', [ResetPasswordController::class, "sendMail"]);
Route::post('change-password', [ResetPasswordController::class, "reset"]);
