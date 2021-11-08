<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UpvoteController;

/*
|--------------------------------------------------------------------------
| API Routes for Upvote
|--------------------------------------------------------------------------
*/


Route::post('upvote/posts/{id}', [UpvoteController::class, "store"])
    ->middleware('jwt.verify');
Route::delete('upvote/posts/{id}', [UpvoteController::class, "destroy"])
    ->middleware('jwt.verify');
