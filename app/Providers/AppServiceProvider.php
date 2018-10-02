<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Validator\ValidatorWithCode;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        DB::listen(
//            function ($sql) {
//                echo $sql->sql;
//                echo "\n";
//
//                var_dump($sql->bindings);
//            }
//        );
        if(config('app.forceScheme')!=null) {
            URL::forceScheme(config('app.forceScheme'));
        }

        Validator::resolver(function($translator, $data, $rules, $messages)
        {
            return new ValidatorWithCode($translator, $data, $rules, $messages);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
