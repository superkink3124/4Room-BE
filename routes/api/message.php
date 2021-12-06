<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;

Route::get('/rooms/{room_id}/messages', [MessageController::class, "index"])
    ->middleware("jwt.verify");
Route::post('/rooms/{room_id}/messages', [MessageController::class, "store"])
    ->middleware("jwt.verify");

