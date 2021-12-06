<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FollowController;

/*
|--------------------------------------------------------------------------
| API Routes for Post
|--------------------------------------------------------------------------
*/

Route::post('target-users/{id}/follow', [FollowController::class, "store"])
    ->middleware('jwt.verify');
Route::delete('target-users/{id}/follow', [FollowController::class, "destroy"])
    ->middleware('jwt.verify');
Route::get('/users/{id}/following', [FollowController::class, "following"])
    ->middleware('jwt.verify');
Route::get('/users/{id}/followers', [FollowController::class, "followers"])
    ->middleware('jwt.verify');
Route::get('users/follow/suggestion', [FollowController::class, "suggestion"])
    ->middleware('jwt.verify');
