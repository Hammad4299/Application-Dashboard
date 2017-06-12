<?php
/**
 * Created by PhpStorm.
 * User: talha
 * Date: 3/29/2017
 * Time: 11:59 PM
 */

namespace App\Classes;


use Illuminate\Support\Facades\Auth;

class AuthHelper
{
    public static function AppAuth(){
        return Auth::guard('appapi');
    }

    public static function AppUserAuth(){
        return Auth::guard('app-user-api');
    }

    public static function UserAuth(){
        return Auth::guard('web');
    }
}