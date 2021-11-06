<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    // public function index(): Response
    // {
    //     //
    // }

    /**
     * Store a newly created post in database.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $user = $request->user;
            $content = $request->input("content");
            // var_dump($user);
            if ($request->file('file')->isValid()) {
                $upload_file = $request->file('file');
                $path = $upload_file->store("public");
                $file_origin_name = $upload_file->getClientOriginalName();
                $file_size = Storage::size($path);
                $post_model = Post::create([
                    "user_id" => $user->id,
                    "content" => $content,
                    "has_file" => true,
                    "file_address" => $path,
                    "file_name" => $file_origin_name,
                    "file_size" => $file_size,
                ]);
            } 
            else {
                $post_model = Post::create([
                    "user_id" => $user->id,
                    "content" => $content,
                ]);
            }
            return response()->json([
                "success" => true,
                "message" => "Created new post."], 200);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Could not create new post."], 400);
        }
    }

    /**
     * Display the specified post.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            return response()->json([
                "success" => true,
                "data" => Post::findOrFail($id)
                ], 200);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Could not get post."], 400);
        }
    }

    /**
     * Update the specified post in database.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $user = $request->user;
        try {
            $post = Post::findOrFail($id);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Post does not exist in database."], 400);
        }
        if ($user->id == $post->user->id) {
            $post->update(["content" => $request->input("content")]);
            return response()->json([
                "success" => true,
                "message" => "Updated post."], 200);
        } else {
            return response()->json([
                "success" => false,
                "message" => "User does not own post."], 400);
        }
    }
    
    public function download_file(Request $request, $file_path) {
        return Storage::download($file_path);
    }

    /**
     * Remove the specified post from database.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $user = $request->user;
        try {
            $post = Post::findOrFail($id);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Post does not exist in database."], 400);
        }
        if ($user->id == $post->user->id) {
            $post->delete();
            return response()->json([
                "success" => true,
                "message" => "Deleted post."], 200);
        } else {
            return response()->json([
                "success" => false,
                "message" => "User does not own post."], 400);
        }
    }
}
