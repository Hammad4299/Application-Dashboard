<?php
namespace App\Classes;

class Helper{
    public static function getIpLocation($ip){
        return geoip()->getLocation($ip)->getAttribute('country');
    }

    public static function getWithDefault($arrOrObject, $key ,$default = null){
        if(isset($arrOrObject[$key]) && $arrOrObject!==null){
            return $arrOrObject[$key];
        }

        return $default;
    }

    public static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}