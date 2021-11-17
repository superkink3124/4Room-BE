<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;

Route::get('/notification', [NotificationController::class, "notification"])->middleware("jwt.verify");