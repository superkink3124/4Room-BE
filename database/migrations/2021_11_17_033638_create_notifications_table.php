<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade")->onUpdate("cascade");
            $table->unsignedBigInteger("upvote_id")->nullable();
            $table->foreign("upvote_id")->references("id")->on("upvotes")->onDelete("cascade")->onUpdate("cascade");
            $table->unsignedBigInteger("comment_id")->nullable();
            $table->foreign("comment_id")->references("id")->on("comments")->onDelete("cascade")->onUpdate("cascade");
            $table->unsignedBigInteger("follow_id")->nullable();
            $table->foreign("follow_id")->references("id")->on("follows")->onDelete("cascade")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
