<?php
namespace App\Classes;

class Helper{
    public static function getIpLocation($ip){
        return geoip()->getLocation($ip)->getAttribute('country');
    }
}