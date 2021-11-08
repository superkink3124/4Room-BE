<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FollowController;

/*
|--------------------------------------------------------------------------
| API Routes for Post
|--------------------------------------------------------------------------
*/

Route::get('/users/{id}/following', [FollowController::class, "following"])
    ->middleware('jwt.verify');
Route::get('/users/{id}/followers', [FollowController::class, "followers"])
    ->middleware('jwt.verify');
Route::post('follow-user/{id}', [FollowController::class, "store"])
    ->middleware('jwt.verify');
Route::delete('follow-user/{id}', [FollowController::class, "destroy"])
    ->middleware('jwt.verify');
