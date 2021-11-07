<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('files', function (Blueprint $table) {
             $table->id();
             $table->string("name");
             $table->double("size");
             $table->string("address");
             $table->unsignedBigInteger("post_id");
             $table->timestamps();
             $table->foreign("post_id")->references("id")->on("posts")->onDelete("cascade")->onUpdate("cascade");
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
