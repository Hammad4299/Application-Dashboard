<?php

namespace App\Providers;

use App\ViewComposers\MoneyMaker\SidebarApplicationsMenuComposer;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        view()->composer(
            [
                'applications.index',
                'moneymaker.applications.show'
            ],SidebarApplicationsMenuComposer::class
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
