<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Post;
use App\Models\File;
use App\Models\File_Attach_Post;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    //
    public function create_post(Request $request) {
        
        // $user = JWTAuth::authenticate($request->token);
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
                "file_size" => $file_size
            ]);
        } 
        else {
            $post_model = Post::create([
                "user_id" => $user->id,
                "content" => $content,
            ]);
        }
        return response()->json(["success" => true]);
    }
    
    public function download_file(Request $request) {
        $file_path = $request->input("path");
        return Storage::download($file_path);
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