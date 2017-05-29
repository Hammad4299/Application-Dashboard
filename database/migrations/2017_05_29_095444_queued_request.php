<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class QueuedRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('queued_request', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('application_id');
            $table->string('method',32);
            $table->string('url',256);
            $table->string('headers')->nullable();
            $table->string('data')->nullable();
            $table->string('query')->nullable();
            $table->integer('data_type')->nullable();
            $table->longText('response');
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
        Schema::dropIfExists('queued_request');
    }
}
