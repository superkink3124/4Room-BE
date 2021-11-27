<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;

Route::get('/{name}/messages', [MessageController::class, "index"])->middleware("jwt.verify");
Route::post('/create-message/{name}', [MessageController::class, "store"])->middleware("jwt.verify");

