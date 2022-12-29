<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDisputesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_disputes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('dispute_id');
            $table->foreign('dispute_id')
                ->references('id')
                ->on('disputes');
            $table->bigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->bigInteger('coin');
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
        Schema::dropIfExists('user_disputes');
    }
}
