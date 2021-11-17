<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\File;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Notification;
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
     * Create a new comment.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function createComment(Request $request, int $post_id): JsonResponse
    {
        $user = $request->user;

        try {
            Post::findOrFail($post_id);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Could not create comment because this post does not exist."
            ], 400);
        }

        $comment = Comment::create([
            "user_id" => $user->id,
            "post_id" => $post_id,
            "content" => $request->input("content")
        ]);
        NotificationController::update(Notification::where("comment_id", $comment->id)->first());
        return response()->json([
            "success" => true,
            "message" => "Created new comment."
        ], 200);
    }

    /**
     * Update an existing comment.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function updateComment(Request $request, int $post_id, int $id): JsonResponse
    {
        $user = $request->user;

        try {
            Post::findOrFail($post_id);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "This post does not exist in database."
            ], 400);
        }

        try {
            $comment = Comment::where("user_id", $user->id)
                ->where("post_id", $post_id)
                ->findOrFail($id);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Comment does not exist in this post."
            ], 400);
        }

        if ($request->input("content") == $comment->content) {
            return response()->json([
                "success" => false,
                "message" => "You have not changed the comment yet."
            ], 400);
        }

        $comment->update(["content" => $request->input("content")]);
        return response()->json([
            "success" => true,
            "message" => "Updated comment."
        ], 200);
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
     * Delete comment.
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function deleteComment(Request $request, int $post_id, int $id): JsonResponse
    {
        $user = $request->user;

        try {
            Post::findOrFail($post_id);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "This post does not exist in database."
            ], 400);
        }

        try {
            $comment = Comment::where("user_id", $user->id)
                ->where("post_id", $post_id)
                ->findOrFail($id);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Comment does not exist in this post."
            ], 400);
        }

        $comment->delete();
        return response()->json([
            "success" => true,
            "message" => "Deleted comment."
        ], 200);
    }
}
