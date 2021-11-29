<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;

Route::get('/messages/{name}', [MessageController::class, "index"])->middleware("jwt.verify");
Route::post('/messages/create/{name}', [MessageController::class, "store"])->middleware("jwt.verify");

