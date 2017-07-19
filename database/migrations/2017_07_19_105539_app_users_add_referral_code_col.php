<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppUsersAddReferralCodeCol extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('app_users', function (Blueprint $table) {
            $table->string('referral_code', 64)->collation('utf8mb4_bin')->dafault('');
            $table->bigInteger('total_referrals')->default(0);
            $table->bigInteger('reward_pending_referrals')->default(0);
            $table->index(['application_id','referral_code'],'referral_code_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('app_users', function (Blueprint $table) {
            $table->dropColumn('referral_code');
            $table->dropIndex('referral_code_index');
        });
    }
}
