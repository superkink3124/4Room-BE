<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| API Routes for Post
|--------------------------------------------------------------------------
*/


Route::post('/posts', [PostController::class, "store"])
    ->middleware('jwt.verify');
Route::get('/posts/{id}', [PostController::class, "show"])
    ->middleware('jwt.verify');
Route::post('/posts/{id}', [PostController::class, "update"])
    ->middleware('jwt.verify');
Route::delete('/posts/{id}', [PostController::class, "destroy"])
    ->middleware('jwt.verify');
Route::get('/users/{id}/posts', [PostController::class, "user"])
    ->middleware('jwt.verify');
Route::get('/users/newsfeed', [PostController::class, "newsfeed"])
    ->middleware('jwt.verify');
