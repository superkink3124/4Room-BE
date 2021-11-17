<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTriggerComment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
        CREATE TRIGGER `add_notification_of_comment` AFTER INSERT ON `comments`
         FOR EACH ROW BEGIN
        INSERT INTO notifications
        (notifications.user_id, notifications.comment_id, notifications.created_at, notifications.updated_at)
        VALUES
        ((SELECT posts.user_id FROM posts WHERE posts.id = NEW.post_id LIMIT 1), NEW.id, CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP());
        END");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trigger_comment');
    }
}
