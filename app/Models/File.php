<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "size",
        "address",
        "post_id"
    ];

    static public function storage_file(Request $request, Post $post)
    {
        $upload_file = $request->file('file');
        $path = $upload_file->store("public");
        $file_origin_name = $upload_file->getClientOriginalName();
        $file_size = Storage::size($path);
        $file = File::create([
            "name" => $file_origin_name,
            "size" => $file_size,
            "address" => $path,
            "post_id" => $post->id
        ]);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
