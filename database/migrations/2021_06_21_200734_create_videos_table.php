<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('title')->nullable();
            $table->bigInteger('view_count')->nullable();
            $table->bigInteger('like_count')->nullable();
            $table->bigInteger('dislike_count')->nullable();
            $table->bigInteger('comment_count')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->string('thumbnails')->nullable();
            $table->string('channel_id')->nullable(false);
            $table->foreign('channel_id')
                ->references('uuid')
                ->on('channels');
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
        Schema::dropIfExists('videos');
    }
}
