<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| API Routes for Post
|--------------------------------------------------------------------------
*/


Route::get('posts/{id}', [PostController::class, "show"])
    ->middleware('jwt.verify');
Route::get('users/{id}/posts', [PostController::class, "user"])
    ->middleware('jwt.verify');
Route::get('/newsfeed', [PostController::class, "newsfeed"])
    ->middleware('jwt.verify');
Route::post('posts/{id}/edit', [PostController::class, "update"])
    ->middleware('jwt.verify');
Route::post('posts/create', [PostController::class, "store"])
    ->middleware('jwt.verify');
Route::delete('posts/{id}', [PostController::class, "destroy"])
    ->middleware('jwt.verify');
