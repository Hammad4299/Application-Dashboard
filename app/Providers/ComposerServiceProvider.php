<?php

namespace App\Providers;

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
//        view()->composer(
//            [
//                'user.dashboard',
//                'user.settings',
//                'user.connections',
//				'user.preloaded-content',
//                'user.profile',
//                'user.share-requests',
//                'privacy-policy',
//                'termsofuse',
//                'user.dialogs',
//            ],
//            'App\ViewComposers\UserInfoComposer'
//        );
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
