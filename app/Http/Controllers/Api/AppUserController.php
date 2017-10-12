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
    public function __construct(AppUserAccessor $appUserAccessor)
    {
        $this->appuserAccessor = $appUserAccessor;
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
     * @apiGroup AppUser (General)
     * @apiVersion 0.1.0
     * @apiUse AppUserLoginCommon
     * @apiUse queuedSupport
     * @apiUse authApp
     * @apiUse errorUnauthorized
     **/
    public function login(Request $request){
        $resp = self::processAppResponseForLogin($this->appuserAccessor->login(AuthHelper::AppAuth()->user()->id,$request->all()));
        $this->appuserAccessor->onComplete($resp,$request->all(),AuthHelper::AppAuth()->user()->id);
        return response()->json($resp);
    }

    /**
     * @api {POST} application/user Register User
     * @apiGroup AppUser (General)
     * @apiVersion 0.1.0
     * @apiUse AppUserRegisterCommon
     * @apiUse queuedSupport
     * @apiUse commonUserUpdateRegisterParams
     * @apiUse authApp
     * @apiUse errorUnauthorized
     **/
    public function create(Request $request){
        $resp = $this->appuserAccessor->createUpdateUser($request->all(),null,AuthHelper::AppAuth()->user()->id);
        $this->appuserAccessor->onComplete($resp,$request->all(),AuthHelper::AppAuth()->user()->id);
        return response()->json($resp);
    }

    /**
     * @api {POST} application/user/social/facebook-login Login/Register Using Facebook
     * @apiGroup AppUser (General)
     * @apiVersion 0.1.0
     * @apiUse AppUserSocialLoginCommon
     * @apiUse queuedSupport
     * @apiUse commonUserUpdateRegisterParams
     * @apiUse authApp
     * @apiUse errorUnauthorized
     **/
    public function loginWithFacebook(Request $request){
        $resp = self::processAppResponseForLogin($this->appuserAccessor->loginRegisterWithFacebook($request->all(),AuthHelper::AppAuth()->user()->id));
        $this->appuserAccessor->onComplete($resp,$request->all(),AuthHelper::AppAuth()->user()->id);
        return response()->json($resp);
    }

    /**
     * @api {POST} application/user/update Update user
     * @apiGroup AppUser (General)
     * @apiVersion 0.1.0
     * @apiUse AppUserEditCommon
     * @apiUse authUser
     * @apiUse commonUserUpdateRegisterParams
     * @apiUse queuedSupport
     * @apiUse errorUnauthorized
     **/
    public function update(Request $request){
        $resp = $this->appuserAccessor->createUpdateUser($request->all(), AuthHelper::AppUserAuth()->user(), null);
        $this->appuserAccessor->onComplete($resp,$request->all(),AuthHelper::AppUserAuth()->user()->application_id);
        return response()->json($resp);
    }

    /**
     * @api {GET} application/user/me Get Me
     * @apiGroup AppUser (General)
     * @apiVersion 0.1.0
     * @apiUse AppUserGetCommon
     * @apiUse authUser
     * @apiUse errorUnauthorized
     **/
    public function getMe(Request $request){
        $resp = $this->appuserAccessor->getUserWithScore(AuthHelper::AppUserAuth()->user()->id);
        return response()->json($resp);
    }
}