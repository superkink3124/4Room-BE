<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\File;
use App\Models\Post;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a list posts in user's newsfeed
     */
    public function newsfeed(Request $request) {
        $user = $request->user;
        $followings = $user->followings;
        $followings_id = [$user->id];
        foreach ($followings as $following) {
            array_push($followings_id, $following->id);
        }
        return new PostCollection(Post::whereIn('user_id', $followings_id)
                                        ->orderBy('updated_at', 'desc')
                                        ->simplePaginate(15));
    }

    /**
     * Display a list posts owned by user_id.
     * @param int $id
     * @return JsonResponse|PostCollection
     */
     public function user(int $id)
     {
         try {
             $user = User::findOrFail($id);
         } catch (Exception $e) {
             return response()->json([
                 "success" => false,
                 "message" => "User does not exist in database."], 400);
         }
         return new PostCollection($user->posts);
     }

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
            $post = Post::create([
                "user_id" => $user->id,
                "content" => $request->input("content"),
            ]);
            if ($request->file('file')->isValid()) {
                File::storage_file($request, $post);
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
     * Display the specified post by id.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            return response()->json([
                "success" => true,
                "data" => new PostResource(Post::findOrFail($id))
                ], 200);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Post does not exist in database."], 400);
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
