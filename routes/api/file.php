<?php

use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes for File
|--------------------------------------------------------------------------
*/


Route::get('download/files/{file_path}', [FileController::class, "download"])->where(["file_path" => '.*']);

