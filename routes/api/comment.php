<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| API Routes for Comment
|--------------------------------------------------------------------------
*/

Route::post('posts/{post_id}/comments/create', [CommentController::class, 'createComment'])
    ->middleware('jwt.verify');
Route::post('posts/{post_id}/comments/{id}/update', [CommentController::class, 'updateComment'])
    ->middleware('jwt.verify');
Route::delete('posts/{post_id}/comments/{id}/delete', [CommentController::class, 'deleteComment'])
    ->middleware('jwt.verify');
