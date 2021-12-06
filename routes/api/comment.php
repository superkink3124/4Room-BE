<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| API Routes for Comment
|--------------------------------------------------------------------------
*/

Route::post('posts/{post_id}/comments', [CommentController::class, 'store'])
    ->middleware('jwt.verify');
Route::post('posts/{post_id}/comments/{comment_id}', [CommentController::class, 'update'])
    ->middleware('jwt.verify');
Route::delete('posts/{post_id}/comments/{comment_id}', [CommentController::class, 'destroy'])
    ->middleware('jwt.verify');
