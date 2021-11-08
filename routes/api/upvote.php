<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UpvoteController;

/*
|--------------------------------------------------------------------------
| API Routes for Upvote
|--------------------------------------------------------------------------
*/

Route::get('posts/{id}/upvote', [UpvoteController::class, "show"]);
Route::post('upvote-post/{id}', [UpvoteController::class, "store"])
    ->middleware('jwt.verify');
Route::delete('upvote-post/{id}', [UpvoteController::class, "destroy"])
    ->middleware('jwt.verify');
