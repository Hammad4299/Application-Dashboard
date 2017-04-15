<?php

namespace App\Models\ModelAccessor;


use App\Classes\AppResponse;
use App\Models\Country;

class CountryAccessor extends BaseAccessor
{
    public function allCountries(){
        $response = new AppResponse();
        $countries = Country::all();
        $response->status = true;
        $response->data = $countries;
        return $response;
    }
}