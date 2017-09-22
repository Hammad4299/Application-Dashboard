<?php

namespace App\Models\ModelAccessor;


use App\Classes\AppResponse;
use App\Models\Country;

class CountryAccessor extends BaseAccessor
{
    public function allCountries($options = []){
        $response = new AppResponse(true);
        $countries = Country::queryData($options);
        $response->data = $countries;
        return $response;
    }
}