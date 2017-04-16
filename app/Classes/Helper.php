<?php


class Helper{
    public static function getIpLocation($ip){
        return geoip()->getLocation($ip)->getAttribute('country');
    }
}