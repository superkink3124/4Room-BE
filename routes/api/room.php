<?php

use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;

Route::get('/rooms/{id}', [RoomController::class, "index"])->middleware("jwt.verify");
