<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Upvote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UpvoteController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function store(Request $request, int $id): JsonResponse
    {
        $user = $request->user;
        try {
            $post = Post::findOrFail($id);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Post does not exist in database."], 400);
        }
        $all_upvote = $post->upvotes;
        foreach ($all_upvote as $upvote) {
            if ($upvote->user_id == $user->id) {
                return response()->json([
                    "success" => false,
                    "message" => "User already upvote post."], 400);
            }
        }
        Upvote::create([
            "user_id" => $user->id,
            "post_id" => $post->id
        ]);
        return response()->json([
            "success" => true,
            "message" => "Upvoted post."], 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
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
                "message" => "User did not upvote post before."], 400);
        }
        $upvote->delete();
        return response()->json([
            "success" => true,
            "message" => "Removed upvote."], 400);
    }
}
