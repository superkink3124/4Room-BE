<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTriggerUpdatePostUpdateAtWhenComment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        DB::unprepared("
//        CREATE TRIGGER `update_post_update_at` AFTER INSERT ON `comments` FOR EACH ROW BEGIN
//
//        UPDATE posts
//        SET posts.updated_at = NOW()
//        WHERE posts.id = NEW.post_id;
//
//        END
//        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trigger_update_post_update_at_when_comment');
    }
}
