<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('api_token', 128)->collation('utf8mb4_bin');
            $table->integer('application_id');
            $table->string('username', 128)->collation('utf8mb4_bin');
            $table->string('password', 128)->nullable();
            $table->string('email', 128)->nullable();
            $table->string('first_name', 128)->nullable();
            $table->string('last_name', 128)->nullable();
            $table->integer('gender')->nullable();
            $table->string('country')->nullable();
            $table->json('extra')->nullable();
            $table->integer('created_at');

            $table->unique(['application_id','username']);
            $table->index(['application_id','username','password']);
            $table->index('api_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_users');
    }
}
