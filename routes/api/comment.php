<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| API Routes for Comment
|--------------------------------------------------------------------------
*/

Route::post('posts/{post_id}/create-comment', [CommentController::class, 'createComment'])
    ->middleware('jwt.verify');
Route::delete('posts/{post_id}/comment_id={id}', [CommentController::class, 'deleteComment'])
    ->middleware('jwt.verify');