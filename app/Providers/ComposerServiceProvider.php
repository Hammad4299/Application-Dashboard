<?php

namespace App\Providers;

use App\Applications\BaseApplication;
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
                'applications.create',
                'user.edit-profile'
            ],\App\ViewComposers\SidebarApplicationsMenuComposer::class
        );

        foreach (BaseApplication::getApplicationMap() as $name => $app){
            /**
             * @var BaseApplication $app
             */
            $app->registerViewComposers();
        }
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
