<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Post;

class PostController extends Controller
{
    //
    public function create_post(Request $request) {
        
        // $user = JWTAuth::authenticate($request->token);
        $user = $request->user;
        // var_dump($user);
        $post = Post::create([
            "user_id" => $user->id,
            "content" => $request->input("content"),
        ]);

        return response()->json(["success" => true]);
    }

    public function delete_post(Request $request) {
        
        // $user = JWTAuth::authenticate($request->token);
        $user = $request->user;
        $post_id = $request->input("post_id");
        if(count(Post::where("id", $post_id)->get()) == 0) {
            return response()->json(["success" => false, "message" => "No posts match"]);
        }
        if($user->id != Post::where("id", $post_id)->value("user_id")) {
            return response()->json(["success" => false, "message" => "You are not owner"]);
        }
        $post = Post::where("id", $post_id)->delete();
        return response()->json(["success" => true]);
    }
}