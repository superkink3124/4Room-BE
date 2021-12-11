<?php

namespace App\Http\Controllers;

use App\Models\File;
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
            $file = File::where("address", $address)->firstOrFail();
            return Storage::download($address, $file->name);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "File does not exist."], 404);
        }
    }
}
