<?php

use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes for File
|--------------------------------------------------------------------------
*/


Route::get('download/files/{address}', [FileController::class, "download"])->where(["address" => '.*']);

