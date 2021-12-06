<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Notification;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Create a new comment.
     *
     * @param Request $request
     * @param int $post_id
     * @return JsonResponse
     */
    public function store(Request $request, int $post_id): JsonResponse
    {
        $user = $request->user;
        try {
            Post::findOrFail($post_id);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Post does not exist."
            ], 404);
        }
        if ($request->input("content") == "") {
            return response()->json([
                "success" => false,
                "message" => "Your comment is empty."
            ], 400);
        }
        $comment = Comment::create([
            "user_id" => $user->id,
            "post_id" => $post_id,
            "content" => $request->input("content")
        ]);
        try {
            $notification = Notification::where("comment_id", $comment->id)->firstOrFail();
            NotificationController::update($notification);
        } catch(Exception $ex) {

        }
        return response()->json([
            "success" => true,
            "message" => "Created new comment.",
            "data" => new CommentResource($comment)
        ], 200);
    }

    /**
     * Update an existing comment.
     *
     * @param Request $request
     * @param int $post_id
     * @param int $comment_id
     * @return JsonResponse
     */
    public function update(Request $request, int $post_id, int $comment_id): JsonResponse
    {
        $user = $request->user;
        try {
            $comment = Comment::where("user_id", $user->id)
                ->where("post_id", $post_id)
                ->findOrFail($comment_id);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Comment does not exist."
            ], 404);
        }
        $comment->update(["content" => $request->input("content")]);
        return response()->json([
            "success" => true,
            "message" => "Updated comment.",
            "data" => new CommentResource($comment)
        ], 200);
    }

    /**
     * Delete comment.
     *
     * @param Request $request
     * @param int $post_id
     * @param int $comment_id
     * @return JsonResponse
     */
    public function destroy(Request $request, int $post_id, int $comment_id): JsonResponse
    {
        $user = $request->user;
        try {
            $comment = Comment::where("user_id", $user->id)
                ->where("post_id", $post_id)
                ->findOrFail($comment_id);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Comment does not exist."
            ], 404);
        }
        $comment->delete();
        return response()->json([
            "success" => true,
            "message" => "Deleted comment."
        ], 200);
    }
}
