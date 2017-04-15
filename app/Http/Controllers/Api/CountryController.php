<?php

namespace App\Http\Controllers;

use App\Models\ModelAccessor\CountryAccessor;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    protected $countryAccessor;
    public function __construct(CountryAccessor $accessor){
        $this->countryAccessor = $accessor;
    }


    public function index(){
        $countries = $this->countryAccessor->allCountries();
        return response()->json($countries);
    }

}
