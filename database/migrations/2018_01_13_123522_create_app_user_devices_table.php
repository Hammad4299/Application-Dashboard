<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppUserDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_user_devices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('app_user_id');
            $table->string('device_name');
            $table->integer('last_updated_at');
            $table->index(['app_user_id','device_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_user_devices');
    }
}
