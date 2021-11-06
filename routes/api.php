<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\UserController;

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

Route::get("download_file", [PostController::class, 'download_file']);
// Authen API
Route::post('login', [AuthController::class, 'authenticate']);
Route::post('register', [AuthController::class, 'register']);
Route::post('reset-password', [ResetPasswordController::class, "sendMail"]);
Route::post('change-password', [ResetPasswordController::class, "reset"]);

// User API
Route::get('users/{id}', [UserController::class, 'show']);
Route::get('users/', [UserController::class, 'show']);
//Route::post('users', [UserController::class, 'store']);
//Route::delete('users/{id}', [UserController::class, 'destroy']);
Route::get('users/search/{name}', [UserController::class, 'search']);

// Post API
Route::get('posts/{id}', [PostController::class, "show"]);

Route::group(['middleware' => ['jwt.verify']], function() {
    // Authen API
    Route::get('logout', [AuthController::class, 'logout']);
    Route::post('create_post', [PostController::class, "create_post"]);
    Route::post('delete_post', [PostController::class, "delete_post"]);
    Route::post('profile', [UserController::class, 'update']);

    Route::post('posts/{id}/edit', [PostController::class, "update"]);
    Route::post('posts/create', [PostController::class, "store"]);
    Route::delete('posts/{id}', [PostController::class, "destroy"]);
    Route::get('download_file/{file_path}', [PostController::class, "download_file"])->where(["file_path" => '.*']);
});
