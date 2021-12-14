<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\File;
use App\Models\Post;
use App\Models\Upvote;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * List posts in user's newsfeed = Post of following -> (random 50 post);
     */
    public function newsfeed(Request $request): PostCollection
    {
        $result_post_ids = [];
        $user = $request->user;
        //////////////////////////////////////////////////////////////
        $followings = $user->following;
        $following_ids = [$user->id];
        foreach ($followings as $following) {
            array_push($following_ids, $following->id);
        }
        $posts_following = Post::whereIn('user_id', $following_ids)->get();
        $comments_following = Comment::whereIn('user_id', $following_ids)->get();
        $upvotes_following = Upvote::whereIn('user_id', $following_ids)->get();
        foreach ($posts_following as $post_following) {
            if (in_array($post_following->id, $result_post_ids)) {
                continue;
            }
            array_push($result_post_ids, $post_following->id);
        }
        foreach ($comments_following as $comment_following) {
            if (in_array($comment_following->post_id, $result_post_ids)) {
                continue;
            }
            array_push($result_post_ids, $comment_following->post_id);
        }
        foreach ($upvotes_following as $upvote_following) {
            if (in_array($upvote_following->post_id, $result_post_ids)) {
                continue;
            }
            array_push($result_post_ids, $upvote_following->post_id);
        }
        //////////////////////////////////////////////////////////////
        $posts = Post::all();
        $other_posts = [];
        foreach ($posts as $post) {
            array_push($other_posts, new PostResource($post));
        }
//        usort($other_posts, function($a, $b) {return $a->upvotes->count() < $b->upvotes->count();});
        shuffle($other_posts);
        $other_posts = array_slice($other_posts, 0, sizeof($result_post_ids) / 5);
        foreach ($other_posts as $other_post) {
            if (in_array($other_post->id, $result_post_ids)) {
                continue;
            }
            array_push($result_post_ids, $other_post->id);
        }
        return new PostCollection(Post::whereIn('id', $result_post_ids)
                                        ->orderBy('updated_at', 'desc')
                                        ->simplePaginate(10));
    }

    /**
     * List posts owned by user_id.
     * @param int $user_id
     * @return JsonResponse|PostCollection
     */
     public function user(int $user_id)
     {
         try {
             $user = User::findOrFail($user_id);
         } catch (Exception $e) {
             return response()->json([
                 "success" => false,
                 "message" => "User does not exist in database."], 404);
         }
         return new PostCollection($user->posts()
                                        ->orderBy('updated_at', 'desc')
                                        ->simplePaginate(10));
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
                "title" => $request->input("title"),
                "content" => $request->input("content")
            ]);
            if ($request->file('file') !== null && $request->file('file')->isValid()) {
                File::storage_file($request, $post);
            }
            return response()->json([
                "success" => true,
                "message" => "Created new post.",
                "data" => new PostResource($post)], 200);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Could not create new post."], 400);
        }
    }

    /**
     * Display the specified post by id.
     *
     * @param int $post_id
     * @return JsonResponse
     */
    public function show(int $post_id): JsonResponse
    {
        try {
            return response()->json([
                "success" => true,
                "data" => new PostResource(Post::findOrFail($post_id))
                ], 200);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Post does not exist in database."], 404);
        }
    }

    /**
     * Update the specified post in database.
     *
     * @param Request $request
     * @param int $post_id
     * @return JsonResponse
     */
    public function update(Request $request, int $post_id): JsonResponse
    {
        $user = $request->user;
        try {
            $post = Post::findOrFail($post_id);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Post does not exist in database."], 404);
        }
        if ($user->id == $post->user->id) {
            $post->update([
                "title" => $request->input("title"),
                "content" => $request->input("content")]);
            return response()->json([
                "success" => true,
                "message" => "Updated post.",
                "data" => new PostResource($post)], 200);
        } else {
            return response()->json([
                "success" => false,
                "message" => "User does not own post."], 409);
        }
    }

    /**
     * Remove the specified post from database.
     *
     * @param Request $request
     * @param int $post_id
     * @return JsonResponse
     */
    public function destroy(Request $request, int $post_id): JsonResponse
    {
        $user = $request->user;
        try {
            $post = Post::findOrFail($post_id);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Post does not exist in database."], 404);
        }
        if ($user->id == $post->user->id) {
            try {
                $file = File::where('post_id', $post->id)->firstOrFail();
                Storage::delete($file->address);
            }
            catch (Exception $ex) {

            }
            $post->delete();
            return response()->json([
                "success" => true,
                "message" => "Deleted post."], 200);
        } else {
            return response()->json([
                "success" => false,
                "message" => "User does not own post."], 409);
        }
    }
}
