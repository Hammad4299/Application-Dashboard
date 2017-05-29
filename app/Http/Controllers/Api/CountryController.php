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

    /**
     * @api {GET} country/list Get Countries List
     * @apiGroup Country
     * @apiSuccess (Success) {Response(Country[])} Body Json of <b>Response</b> Object
     * @apiUse authApp
     * @apiUse errorUnauthorized
     * @param Request $request
     * @return $mixed
     **/
    public function index(){
        $countries = $this->countryAccessor->allCountries();
        return response()->json($countries);
    }

}
