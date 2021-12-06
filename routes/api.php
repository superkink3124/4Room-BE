<?php

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

Route::group([], __DIR__ . '/api/auth.php');
Route::group([], __DIR__ . '/api/post.php');
Route::group([], __DIR__ . '/api/user.php');
Route::group([], __DIR__ . '/api/upvote.php');
Route::group([], __DIR__ . '/api/follow.php');
Route::group([], __DIR__ . '/api/comment.php');
Route::group([], __DIR__ . '/api/file.php');
Route::group([], __DIR__ . '/api/notification.php');
Route::group([], __DIR__ . '/api/message.php');
Route::group([], __DIR__ . '/api/room.php');
