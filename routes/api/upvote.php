<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UpvoteController;

/*
|--------------------------------------------------------------------------
| API Routes for Upvote
|--------------------------------------------------------------------------
*/

Route::post('posts/{id}/upvote', [UpvoteController::class, "store"])
    ->middleware('jwt.verify');
Route::delete('posts/{id}/upvote', [UpvoteController::class, "destroy"])
    ->middleware('jwt.verify');
Route::get('posts/{id}/upvote', [UpvoteController::class, "is_upvoted"])
    ->middleware('jwt.verify');
Route::get('posts/{id}/upvotes/users', [UpvoteController::class, "show"])
    ->middleware('jwt.verify');
