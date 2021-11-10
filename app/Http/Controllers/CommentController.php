<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\File;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Create a new comment
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function createComment(Request $request): JsonResponse
    {
        //
        try {
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => ""
            ], 400);
        }
        return response()->json([]);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param int  $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        //
        return response()->json([]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Delete comment
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function deleteComment(Request $request, int $id): JsonResponse
    {
        $user = $request->user;
        try {
            $comment = Comment::findOrFail($id);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Comment does not exist in database."
            ], 400);
        }

        if ($user->id == $comment->user->id) {
            $comment->delete();
            return response()->json([
                "success" => true,
                "message" => "Delete comment."
            ], 200);
        } else {
            return response()->json([
                "success" => false,
                "message" => "User does not own comment."
            ], 400);
        }
    }
}
