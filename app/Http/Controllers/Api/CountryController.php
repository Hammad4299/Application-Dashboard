<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ModelAccessor\CountryAccessor;

class CountryController extends Controller
{
    protected $countryAccessor;
    public function __construct(CountryAccessor $accessor){
        $this->countryAccessor = $accessor;
        $this->middleware('authcheck:appapi');
    }

    public function index(){
        $countries = $this->countryAccessor->allCountries();
        return response()->json($countries);
    }

}
