<?php

namespace App\Providers;

use App\Models\AppUser;
use App\Models\AppUserTransaction;
use App\Models\ModelAccessor\AppUserTransactionAccessor;
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
//            }
//        );


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
