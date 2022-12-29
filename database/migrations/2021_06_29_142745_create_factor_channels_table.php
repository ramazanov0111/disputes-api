<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactorChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factor_channels', function (Blueprint $table) {
            $table->id();
            $table->string('channel_id')->unique()->nullable(false);
            $table->foreign('channel_id')
                ->references('uuid')
                ->on('channels');
            $table->bigInteger('latest_video_id')->nullable(false);
            $table->foreign('latest_video_id')
                ->references('id')
                ->on('last_video_channel');
            $table->string('f_view')->nullable(false);
            $table->string('f_like')->nullable(false);
            $table->string('f_dislike')->nullable(false);
            $table->string('f_comment')->nullable(false);
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
        Schema::dropIfExists('factor_channels');
    }
}
