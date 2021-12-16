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
	DECLARE post_owner INTEGER;
	SELECT posts.user_id INTO post_owner FROM posts WHERE posts.id = NEW.post_id LIMIT 1;
    IF NEW.user_id != post_owner THEN
    	INSERT INTO notifications
        (notifications.user_id, notifications.upvote_id, notifications.created_at, notifications.updated_at)
        VALUES
        (post_owner, NEW.id, NEW.created_at, NEW.updated_at);
	END IF;        
END
        ");
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
