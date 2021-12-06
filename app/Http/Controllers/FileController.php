<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileController extends Controller
{
    /***
     * Download a file
     * @param $address
     * @return JsonResponse|StreamedResponse
     */
    public function download($address)
    {
        try {
            return Storage::download($address);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "File does not exist."], 404);
        }
    }
}
