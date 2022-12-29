<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisputesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disputes', function (Blueprint $table) {
            $table->id();
            $table->string('video_id')->nullable(false);
            $table->foreign('video_id')
                ->references('uuid')
                ->on('videos');
            $table->enum('method', \App\Models\Disputes::METHOD_DISPUTE_ALL);
            $table->enum('type', \App\Models\Disputes::TYPE_DISPUTE_ALL);
            /* Variable X (value) */
            $table->string('variable_x')->nullable(true);
            /* Variable Y (time) */
            $table->timestamp('variable_y');
            $table->integer('time_bet');
            /* Expected result */
            $table->boolean('status');
            /* End result */
            $table->boolean('result')->default(false);
            $table->boolean('is_actual')->default(true);
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
        Schema::dropIfExists('disputes');
    }
}
