<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTriggerFollow extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
        CREATE TRIGGER `add_notification_of_follow` AFTER INSERT ON `follows`
 FOR EACH ROW BEGIN
	IF NEW.source_id != NEW.target_id THEN
    	INSERT INTO notifications
        (notifications.user_id, notifications.follow_id, notifications.created_at, notifications.updated_at)
		VALUES
        (NEW.target_id, NEW.id, NEW.created_at, NEW.updated_at);
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
        Schema::dropIfExists('trigger_follow');
    }
}
