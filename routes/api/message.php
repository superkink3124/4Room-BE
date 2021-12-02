<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;

Route::get('/messages/{room_id}', [MessageController::class, "index"])->middleware("jwt.verify");
Route::post('/messages/create/{room_id}', [MessageController::class, "store"])->middleware("jwt.verify");

