<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Models\Notification;
use App\Models\Post;
use App\Models\Upvote;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UpvoteController extends Controller
{
    /**
     * Store a new upvote in database.
     *
     * @param Request $request
     * @param int $post_id
     * @return JsonResponse
     */
    public function store(Request $request, int $post_id): JsonResponse
    {
        $user = $request->user;
        try {
            $post = Post::findOrFail($post_id);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Post does not exist in database."], 404);
        }
        $all_upvote = $post->upvotes;
        foreach ($all_upvote as $upvote) {
            if ($upvote->user_id == $user->id) {
                return response()->json([
                    "success" => false,
                    "message" => "User already upvote post."], 409);
            }
        }
        $upvote = Upvote::create([
            "user_id" => $user->id,
            "post_id" => $post->id
        ]);
        try {
            $upvote = Notification::where("upvote_id", $upvote->id)->firstOrFail();
            NotificationController::update($upvote);
        } catch(Exception $ex) {

        }
        return response()->json([
            "success" => true,
            "message" => "Upvoted post."], 200);
    }

    /**
     * Display list users upvote post.
     *
     * @param int $post_id
     * @return UserCollection|JsonResponse
     */
    public function show(int $post_id)
    {
        try {
            $post = Post::findOrFail($post_id);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Post does not exist in database."], 400);
        }
        $all_upvote = $post->upvotes;
        $users = [];
        foreach ($all_upvote as $upvote) {
            $user = $upvote->user;
            $users[] = $user;
        }
        return new UserCollection($users);
    }

    /**
     * Check if a user upvoted a post
     * @param Request $request
     * @param int $post_id
     * @return JsonResponse
     */
    public function is_upvoted(Request $request, int $post_id): JsonResponse
    {
        $user = $request->user;
        try {
            $upvote = Upvote::where("post_id", $post_id)
                            ->where("user_id", $user->id)
                            ->firstOrFail();
        } catch (\Exception $e) {
            return response()->json([
                "success" => true,
                "message" => "Successful operations.",
                "is_upvoted" => false], 200);
        }
        return response()->json([
            "success" => true,
            "message" => "Successful operations.",
            "is_upvoted" => true], 200);
    }

    /**
     * Remove upvote from database.
     *
     * @param Request $request
     * @param int $post_id
     * @return JsonResponse
     */
    public function destroy(Request $request, int $post_id): JsonResponse
    {
        $user = $request->user;
        try {
            $upvote = Upvote::where("user_id", $user->id)
                            ->where("post_id", $post_id)
                            ->firstOrFail();
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "User did not upvote post before."], 404);
        }
        $upvote->delete();
        return response()->json([
            "success" => true,
            "message" => "Removed upvote."], 200);
    }
}
