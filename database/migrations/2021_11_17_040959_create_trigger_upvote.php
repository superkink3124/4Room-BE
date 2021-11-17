<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTriggerUpvote extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
        CREATE TRIGGER `add_notification_of_upvote` AFTER INSERT ON `upvotes`
         FOR EACH ROW BEGIN
        
        INSERT INTO notifications
        (notifications.user_id, notifications.upvote_id)
        VALUES
        ((SELECT posts.user_id FROM posts WHERE posts.id = NEW.post_id LIMIT 1), NEW.id);
        
        END");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trigger_upvote');
    }
}
