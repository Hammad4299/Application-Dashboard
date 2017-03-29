<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppUsersScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_users_scores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('application_id');
            $table->integer('app_user_id');
            $table->integer('leaderboard_id');
            $table->bigInteger('score');
            $table->integer('modified_at');

            $table->index(['leaderboard_id','score']);
            $table->index(['leaderboard_id','app_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_users_scores');
    }
}
