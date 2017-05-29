<?php
namespace App\Http\Controllers\Api;
use App\Classes\AuthHelper;
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
        $this->middleware('authcheck:appapi',['except'=>['create']]);
    }

    /**
     * @api {POST} application Create Application
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
        $resp = $this->applicationAccessor->createOrUpdate($request->all());
        return response()->json($resp);
    }

    /**
     * @api {POST} application/update Update Application
     * @apiGroup Application
     * @apiUse queuedSupport
     * @apiDescription Update an Application
     * @apiParam (form) {String} name Name of Application
     * @apiParam (form) {String} [fb_appid=old_value] Facebook id for this application
     * @apiParam (form) {String} [fb_appsecret=old_value] Facebook secret for this application
     * @apiSuccess (Success) {Response(Application)} Body
     * @apiUse errorUnauthorized
     * @apiUse authApp
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request){
        $resp = $this->applicationAccessor->createOrUpdate($request->all(),AuthHelper::AppAuth()->user());
        $this->applicationAccessor->onComplete($resp,$request->all(),AuthHelper::AppAuth()->user()->id);
        return response()->json($resp);
    }
}