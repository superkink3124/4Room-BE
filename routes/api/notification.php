<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;

Route::get('/notification', [NotificationController::class, "notification"])->middleware("jwt.verify");
Route::get('/noti/{id}', [NotificationController::class, "show"])->middleware('jwt.verify');
Route::get('/count_unseen_notification', [NotificationController::class, "count_unseen_notification"])->middleware('jwt.verify');
Route::post('/update_last_update_notification', [NotificationController::class, "update_last_update_notification"])->middleware('jwt.verify');