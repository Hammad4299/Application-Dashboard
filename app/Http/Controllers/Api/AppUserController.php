<?php
namespace App\Http\Controllers\Api;
use App\Classes\AppResponse;
use App\Classes\AuthHelper;
use App\Http\Controllers\Controller;
use App\Models\AppUser;
use App\Models\ModelAccessor\AppUserAccessor;
use App\Validator\ErrorCodes;
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
        $this->middleware('authcheck:appapi',['only'=>['create','login','loginWithFacebook']]);
        $this->middleware('authcheck:app-user-api',['except'=>['create','login','loginWithFacebook']]);
    }

    public static function processAppResponseForLogin(AppResponse $response){
        if($response->getStatus()){
            if($response->data instanceof AppUser && $response->data->state===AppUser::$STATE_BLOCKED){
                $response->addError('state','Account is blocked',ErrorCodes::$ACCOUNT_BLOCKED);
            }
        }
        return $response;
    }

    /**
     * @api {POST} application/user/login Login User
     * @apiGroup AppUser
     * @apiVersion 0.1.0
     * @apiDescription Login user and get user Api key. <b>User scores (with leaderboard) will also present in returned object</b>
     * @apiParam (form) {String} username
     * @apiParam (form) {String} Password
     * @apiUse queuedSupport
     * @apiSuccess (Success) {Response(AppUser)} Body Json of <b>Response</b> Object
     * @apiUse authApp
     * @apiUse errorUnauthorized
     * @param Request $request
     * @return $mixed
     **/
    public function login(Request $request){
        $resp = self::processAppResponseForLogin($this->appuserAccessor->login(AuthHelper::AppAuth()->user()->id,$request->all()));
        $this->appuserAccessor->onComplete($resp,$request->all(),AuthHelper::AppAuth()->user()->id);
        return response()->json($resp);
    }

    /**
     * @api {POST} application/user Register User
     * @apiGroup AppUser
     * @apiVersion 0.1.0
     * @apiDescription Api token will be null
     * @apiParam (form) {String} username
     * @apiParam (form) {String} [Password]
     * @apiParam (form) {String} [referral_code] Referral code used to signup
     * @apiParam (form) {Integer} [referral_code_length=6] Length of referral code to generate for this user
     * @apiUse queuedSupport
     * @apiUse commonUserUpdateRegisterParams
     * @apiSuccess (Success) {Response(AppUser)} Body Json of <b>Response</b> Object
     * @apiUse authApp
     * @apiUse errorUnauthorized
     * @param Request $request
     * @return $mixed
     **/
    public function create(Request $request){
        $resp = $this->appuserAccessor->createUpdateUser($request->all(),null,AuthHelper::AppAuth()->user()->id);
        $this->appuserAccessor->onComplete($resp,$request->all(),AuthHelper::AppAuth()->user()->id);
        return response()->json($resp);
    }

    /**
     * @api {POST} application/user/social/facebook-login Login/Register Using Facebook
     * @apiGroup AppUser
     * @apiVersion 0.1.0
     * @apiDescription Login/Register user and get user Api key. <b>User scores (with leaderboard) will also present in returned object if that user was already registered. Api token will be null if user wasn't already registered</b>
     * @apiParam (form) {String} fb_access_token
     * @apiUse queuedSupport
     * @apiParam (form) {String} [username]
     * @apiParam (form) {String} [Password]
     * @apiParam (form) {String} [referral_code] Referral code used to signup
     * @apiParam (form) {Integer} [referral_code_length=6] Length of referral code to generate for this user
     * @apiUse commonUserUpdateRegisterParams
     * @apiSuccess (Success) {Response(AppUser)} Body Json of <b>Response</b> Object
     * @apiUse authApp
     * @apiUse errorUnauthorized
     * @param Request $request
     * @return $mixed
     **/
    public function loginWithFacebook(Request $request){
        $resp = self::processAppResponseForLogin($this->appuserAccessor->loginRegisterWithFacebook($request->all(),AuthHelper::AppAuth()->user()->id));
        $this->appuserAccessor->onComplete($resp,$request->all(),AuthHelper::AppAuth()->user()->id);
        return response()->json($resp);
    }

    /**
     * @api {POST} application/user/update Update user
     * @apiGroup AppUser
     * @apiVersion 0.1.0
     * @apiParam (form) {String} username
     * @apiUse queuedSupport
     * @apiParam (form) {String} [Password] If present, password will be updated otherwise it will remain unchanged
     * @apiParam (form) {Integer} [reward_pending_referrals] New value if any given.
     * @apiUse commonUserUpdateRegisterParams
     * @apiParam (form) {String} [fb_access_token] To associate user facebook account. <b>If not specified, it will retain its previous value.</b>
     * @apiSuccess (Success) {Response(AppUser)} Body Json of <b>Response</b> Object
     * @apiUse authUser
     * @apiUse errorUnauthorized
     * @param Request $request
     * @return $mixed
     **/
    public function update(Request $request){
        $resp = $this->appuserAccessor->createUpdateUser($request->all(), AuthHelper::AppUserAuth()->user(), null);
        $this->appuserAccessor->onComplete($resp,$request->all(),AuthHelper::AppUserAuth()->user()->application_id);
        return response()->json($resp);
    }

    /**
     * @api {GET} application/user/me Get Me
     * @apiGroup AppUser
     * @apiVersion 0.1.0
     * @apiDescription Get information about user whose token was used. <b>User scores (with leaderboard) will also present in returned object</b>
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