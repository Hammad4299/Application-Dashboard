<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\ModelAccessor\ApplicationAccessor;
use Illuminate\Http\Request;

/**
 * Created by PhpStorm.
 * User: talha
 * Date: 3/29/2017
 * Time: 7:21 PM
 */
class ApplicationController extends Controller
{
    protected $applicationAccessor;
    public function __construct()
    {
        $this->applicationAccessor = new ApplicationAccessor();
    }

    public function create(Request $request){
        $resp = $this->applicationAccessor->create($request->all());
        return response()->json($resp);
    }
}