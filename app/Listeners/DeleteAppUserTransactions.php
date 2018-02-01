<?php

namespace App\Listeners;

use App\Events\AppUserDeleted;
use App\Models\ModelAccessor\AppUserTransactionAccessor;

class DeleteAppUserTransactions
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AppUserDeleted  $event
     * @return void
     */
    public function handle(AppUserDeleted $event)
    {
        $accessor=new AppUserTransactionAccessor();
        $accessor->deleteUserTransactions($event->app_user_id,$event->app_id);
    }
}
