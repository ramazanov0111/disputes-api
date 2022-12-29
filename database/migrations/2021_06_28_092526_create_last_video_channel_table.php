<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLastVideoChannelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('last_video_channel', function (Blueprint $table) {
            $table->id();
            $table->string('channel_id')->unique()->nullable(false);
            $table->foreign('channel_id')
                ->references('uuid')
                ->on('channels');
            $table->string('video_id')->unique()->nullable(false);
            $table->foreign('video_id')
                ->references('uuid')
                ->on('videos');
            $table->timestamp('published_at')->nullable();
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
        Schema::dropIfExists('last_video_channel');
    }
}
