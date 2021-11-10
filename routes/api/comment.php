<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| API Routes for Comment
|--------------------------------------------------------------------------
*/

Route::post('comment/create', [CommentController::class, 'createComment'])
    ->middleware('jwt.verify');
Route::delete('comment/delete/{id}', [CommentController::class, 'deleteComment'])
    ->middleware('jwt.verify');