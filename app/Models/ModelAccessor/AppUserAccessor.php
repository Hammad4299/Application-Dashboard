<?php

namespace App\Models\ModelAccessor;


use App\Classes\AppResponse;
use App\Classes\Helper;
use App\Models\AppUser;
use App\Models\FacebookApi\FacebookUserApi;
use App\Validator\ErrorCodes;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AppUserAccessor extends BaseAccessor
{
    protected static $TYPE_FACEBOOK = 1;
    public function getUserWithScore($app_user_id){
        $resp = new AppResponse(true);
        $resp->data = AppUser::where('id',$app_user_id)->leaderboards()->first();
        return $resp;
    }

    protected function processSocialData(&$data, $application_id, $types = null){
        if($types === null){
            $types = [self::$TYPE_FACEBOOK];
        }
        $resp = new AppResponse(true);
        $accessor = new ApplicationAccessor();

        if(in_array(self::$TYPE_FACEBOOK,$types)){
            if(!empty(self::getWithDefault($data,'fb_access_token',''))){
                $app = $accessor->getApplication($application_id);

                if(empty($app->fb_appid) || empty($app->fb_appsecret)){
                    $resp->addError('fb_access_token','This app does not support Facebook Auth',ErrorCodes::$FB_AUTH_NOT_AVAILABLE);
                }else{
                    $fbapi = new FacebookUserApi($app->fb_appid,$app->fb_appsecret);
                    $stat = $fbapi->getUserInfo(self::getWithDefault($data,'access_token',''));
                    if($stat->getStatus()){
                        $data['fbid'] = $stat->data['id'];
                    }else{
                        $resp->addError('fb_access_token','Facebook Api Error',ErrorCodes::$FB_AUTH_NOT_AVAILABLE);
                    }
                }
            }
        }

        return $resp;
    }

    public function createUpdateUser($data, $appUser = null, $application_id = null){
        $resp = new AppResponse(true);
        $validator = Validator::make($data, AppUser::creationUpdateRules());

        if ($validator->passes()) {
            if ($appUser != null) {
                $appUser = AppUser::firstOrNew([
                    'id' => $appUser->id
                ]);
                $application_id = $appUser->application_id;
            } else {
                $query = AppUser::where('application_id', $application_id)
                    ->where('username', $data['username']);

                if (!empty($data['email'])) {
                    $query = $query->orWhere('email', $data['email']);
                }

                $d = $query->first();
                if ($d == null) {
                    $appUser = new AppUser();
                    $appUser->api_token = $this->createNewToken();
                    $appUser->username = $data['username'];
                    $appUser->created_at = time();
                } else {
                    if ($d->username == $data['username'])
                        $resp->addError('username', 'Username already registered', ErrorCodes::$USERNAME_EXISTS);
                    if ($d->email == $data['email'] && !empty($data['email']))
                        $resp->addError('email', 'Email already registered', ErrorCodes::$EMAIL_EXISTS);
                }
            }

            if ($appUser != null) {
                $resp = $this->processSocialData($data,$application_id);
                if($resp->getStatus()) {
                    $resp->setStatus(false);
                    $c = self::getWithDefault($data, 'country');
                    if ($c == null) {
                        $ip = request()->ip();
                        $c = Helper::getIpLocation($ip);
                        $data['country'] = $c;
                    }

                    $appUser->email = self::getWithDefault($data, 'email');
                    $appUser->first_name = self::getWithDefault($data, 'first_name');
                    $appUser->last_name = self::getWithDefault($data, 'last_name');
                    $appUser->application_id = $application_id;
                    $appUser->fbid = self::getWithDefault($data, 'fbid', $appUser->fbid);
                    $appUser->gender = self::getWithDefault($data, 'gender');
                    $appUser->country = self::getWithDefault($data, 'country');
                    $appUser->extra = self::getWithDefault($data, 'extra');

                    $password = self::getWithDefault($data, 'password', '');
                    if (!empty($password)) {
                        $appUser->password = Hash::make($password);
                    }
                    $appUser->save();

                    $resp->data = $appUser;
                    $resp->setStatus(true);
                    $appUser->api_token = null;
                }
            }
        }

        $resp->addErrorsFromValidator($validator);
        return $resp;
    }

    public function loginRegisterWithFacebook($data, $application_id){
        $resp = $this->processSocialData($data,$application_id);
        if($resp->getStatus()){
            $user = AppResponse::where('fbid',$data['fbid'])->first();
            if($user!=null) {
                $resp = $this->getUserForLogine($user->id);
            } else {
                $this->createUpdateUser($data, null, $application_id);
            }
        }

        return $resp;
    }

    protected function getUserForLogin($user_id){
        return $this->getUserWithScore($user_id);
    }

    public function login($application_id, $data){
        $resp = new AppResponse();
        $validator = Validator::make($data,AppUser::loginRules());

        if($validator->passes()){
            $user = AppUser::where('application_id',$application_id)
                ->where('username',$data['username'])
                ->first();
            if($user!=null && Hash::check($data['password'],$user->password)){
                $resp = $this->getUserForLogin($user->id);
            }else{
                $resp->addError('password','Invalid username or password',ErrorCodes::$INCORRECT_LOGIN_CREDENTIALS);
            }
        }

        $resp->addErrorsFromValidator($validator);
        return $resp;
    }
}