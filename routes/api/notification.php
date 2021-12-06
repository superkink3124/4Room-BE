<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;

Route::get('/notifications', [NotificationController::class, "notification"])
    ->middleware("jwt.verify");
//Route::get('/notifications/{id}', [NotificationController::class, "show"])
//    ->middleware('jwt.verify');
Route::get('/notifications/count-unseen', [NotificationController::class, "count_unseen_notification"])
    ->middleware('jwt.verify');
Route::post('/notifications/mark-as-seen', [NotificationController::class, "update_last_update_notification"])
    ->middleware('jwt.verify');
