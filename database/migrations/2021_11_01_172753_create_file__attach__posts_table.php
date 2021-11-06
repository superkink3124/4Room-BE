<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileAttachPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('file__attach__posts', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger("post_id");
        //     $table->unsignedBigInteger("file_id");
        //     $table->timestamps();
        //     $table->foreign("post_id")->references("id")->on("posts")->onDelete("cascade")->onUpdate("cascade");
        //     $table->foreign("file_id")->references("id")->on("files")->onDelete("cascade")->onUpdate("cascade");
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file__attach__posts');
    }
}
