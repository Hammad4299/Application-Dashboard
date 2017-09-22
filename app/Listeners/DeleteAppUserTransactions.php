<?php

namespace App\Listeners;

use App\Events\AppUserDeleted;
use App\Events\AppUserDeletion;
use App\Models\ModelAccessor\AppUserTransactionAccessor;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
        $accessor->deleteUserTransactions($event->user->id,$event->user->application_id);
    }
}
