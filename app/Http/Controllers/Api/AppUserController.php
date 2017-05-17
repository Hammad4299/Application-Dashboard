<?php
namespace App\Http\Controllers\Api;
use App\Classes\AuthHelper;
use App\Http\Controllers\Controller;
use App\Models\ModelAccessor\AppUserAccessor;
use Illuminate\Http\Request;

/**
 * Created by PhpStorm.
 * User: talha
 * Date: 3/29/2017
 * Time: 7:21 PM
 */
class AppUserController extends Controller
{
    protected $appuserAccessor;
    public function __construct()
    {
        $this->appuserAccessor = new AppUserAccessor();
        $this->middleware('authcheck:appapi',['only'=>['create','login']]);
        $this->middleware('authcheck:app-user-api',['except'=>['create','login']]);
    }

    /**
     * @api {POST} application/user/login Login User
     * @apiDescription Login user and get user Api key. <b>User scores (with leaderboard) will also present in returned object</b>
     * @apiParam (form) {String} username
     * @apiParam (form) {String} Password
     * @apiGroup AppUser
     * @apiSuccess (Success) {Response(AppUser)} Body Json of <b>Response</b> Object
     * @apiUse authApp
     * @apiUse errorUnauthorized
     * @param Request $request
     * @return $mixed
     **/
    public function login(Request $request){
        $resp = $this->appuserAccessor->login(AuthHelper::AppAuth()->user()->id,$request->all());
        return response()->json($resp);
    }

    /**
     * @api {POST} application/user Register User
     * @apiParam (form) {String} username
     * @apiParam (form) {String} [email]
     * @apiParam (form) {String} [first_name]
     * @apiParam (form) {String} [last_name]
     * @apiParam (form) {Integer=0,1} [gender] 0=Female,1=Male
     * @apiParam (form) {String} [country] If not specified, then country will be set based on IP
     * @apiParam (form) {Json} [extra] Any optional properties
     * @apiParam (form) {String} [Password]
     * @apiGroup AppUser
     * @apiSuccess (Success) {Response(AppUser)} Body Json of <b>Response</b> Object
     * @apiUse authApp
     * @apiUse errorUnauthorized
     * @param Request $request
     * @return $mixed
     **/
    public function create(Request $request){
        $resp = $this->appuserAccessor->createUpdateUser($request->all(),null,AuthHelper::AppAuth()->user()->id);
        return response()->json($resp);
    }

    /**
     * @api {POST} application/user/update Update user
     * @apiParam (form) {String} username This value cannot be updated
     * @apiParam (form) {String} [email]
     * @apiParam (form) {String} [first_name]
     * @apiParam (form) {String} [last_name]
     * @apiParam (form) {Integer=0,1} [gender] 0=Female,1=Male
     * @apiParam (form) {String} [country] If not specified, then country will be set based on IP
     * @apiParam (form) {Json} [extra] Any optional properties
     * @apiParam (form) {String} [Password] If present, password will be updated otherwise it will remain unchanged
     * @apiGroup AppUser
     * @apiSuccess (Success) {Response(AppUser)} Body Json of <b>Response</b> Object
     * @apiUse authUser
     * @apiUse errorUnauthorized
     * @param Request $request
     * @return $mixed
     **/
    public function update(Request $request){
        $resp = $this->appuserAccessor->createUpdateUser($request->all(), AuthHelper::AppUserAuth()->user(), null);
        return response()->json($resp);
    }

    /**
     * @api {GET} application/user/me Get Me
     * @apiDescription Get information about user whose token was used. <b>User scores (with leaderboard) will also present in returned object</b>
     * @apiGroup AppUser
     * @apiSuccess (Success) {Response(AppUser)} Body Json of <b>Response</b> Object
     * @apiUse authUser
     * @apiUse errorUnauthorized
     * @param Request $request
     * @return $mixed
     **/
    public function getMe(Request $request){
        $resp = $this->appuserAccessor->getUserWithScore(AuthHelper::AppUserAuth()->user()->id);
        return response()->json($resp);
    }
}