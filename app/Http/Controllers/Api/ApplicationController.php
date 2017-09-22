<?php
namespace App\Http\Controllers\Api;
use App\Classes\AuthHelper;
use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminAuthCheck;
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
        $this->middleware(AdminAuthCheck::class,['only'=>['create']]);
    }

    /**
     * @api {POST} application Create Application
     * @apiGroup Application
     * @apiVersion 0.1.0
     * @apiDescription Create a new Application
     * @apiParam (form) {String} name Name of Application
     * @apiParam (form) {Integer} user_id Owner of application
     * @apiParam (form) {String} [fb_appid] Facebook id for this application
     * @apiParam (form) {String} [fb_appsecret] Facebook secret for this application
     * @apiParam (form) {String} mapped_name Mapped name of application determining its specific behaviour
     * @apiSuccess (Success) {Response(Application)} Body
     * @apiUse errorUnauthorized
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request){
        $resp = $this->applicationAccessor->createOrUpdate($request->all(),$request->get('user_id'));
        return response()->json($resp);
    }

    /**
     * @api {POST} application/update Update Application
     * @apiGroup Application
     * @apiVersion 0.1.0
     * @apiDescription Update an Application
     * @apiUse queuedSupport
     * @apiParam (form) {String} name Name of Application
     * @apiParam (form) {String} [mapped_name=old_value] Mapped name of application determining its specific behaviour
     * @apiParam (form) {String} [fb_appid=old_value] Facebook id for this application
     * @apiParam (form) {String} [fb_appsecret=old_value] Facebook secret for this application
     * @apiSuccess (Success) {Response(Application)} Body
     * @apiUse errorUnauthorized
     * @apiUse authApp
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request){
        $resp = $this->applicationAccessor->createOrUpdate($request->all(),$request->get('user_id'),AuthHelper::AppAuth()->user());
        $this->applicationAccessor->onComplete($resp,$request->all(),AuthHelper::AppAuth()->user()->id);
        return response()->json($resp);
    }
}