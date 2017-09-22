<?php

use App\Models\AppUserTransaction;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserTransactionRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_transaction_request', function (Blueprint $table){
            $table->increments('id');
            $table->integer('application_id');
            $table->integer('app_user_id');
            $table->integer('amount');
            $table->bigInteger('updated_at');
            $table->bigInteger('request_time');
            $table->index(['application_id','app_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_transaction_request');
    }
}
