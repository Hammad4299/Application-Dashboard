<?php

namespace App\Providers;

use App\Validator\ValidatorWithCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;


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
            Illuminate\Support\Facades\URL::forceScheme(config('app.forceScheme'));
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
