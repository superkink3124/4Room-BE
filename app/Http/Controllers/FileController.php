<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileController extends Controller
{
    /***
     * Download a file
     * @param $file_path
     * @return JsonResponse|StreamedResponse
     */
    public function download($file_path)
    {
        try {
            return Storage::download($file_path);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Could not download file."], 400);
        }
    }
}
