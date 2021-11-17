<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;

Route::get('/notification', [NotificationController::class, "notification"])->middleware("jwt.verify");
Route::get('/noti/{id}', [NotificationController::class, "show"])->middleware('jwt.verify');