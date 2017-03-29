<?php

namespace App\Models\ModelAccessor;


class BaseAccessor
{
    public function createNewToken(){
        return self::generateRandomString(128);
    }

    public static function getWithDefault($arrOrObject, $key ,$default = null){
        if(isset($arrOrObject[$key])){
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