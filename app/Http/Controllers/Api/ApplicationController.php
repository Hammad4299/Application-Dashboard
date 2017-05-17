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

    /**
     * @api {POST} application Create Application
     * @apiName CreateApplication
     * @apiGroup Application
     * @apiDescription Create a new Application
     * @apiParam (form) {String} name Name of Application
     * @apiParam (form) {String} name Name of Application
     * @apiSuccess (Success) {Response(Application)} Body
     * @apiUse errorUnauthorized
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request){
        $resp = $this->applicationAccessor->create($request->all());
        return response()->json($resp);
    }
}