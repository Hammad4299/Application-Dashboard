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
            $fb_access_token = Helper::getWithDefault($data,'fb_access_token','');
            if(!empty($fb_access_token)){
                $r = $accessor->getApplication($application_id);
                $app = $r->data;

                if(empty($app->fb_appid) || empty($app->fb_appsecret)){
                    $resp->addError('fb_access_token','This app does not support Facebook Auth',ErrorCodes::$FB_AUTH_NOT_AVAILABLE);
                }else{
                    $fbapi = new FacebookUserApi($app->fb_appid,$app->fb_appsecret);
                    $stat = $fbapi->getUserInfo($fb_access_token);
                    if($stat->getStatus()){
                        $data['fbid'] = $stat->data['id'];

                        if(!isset($data['username']))
                            $data['username'] = $stat->data['id'];
                    }else{
                        $resp->addError('fb_access_token','Facebook Api Error',ErrorCodes::$FB_AUTH_NOT_AVAILABLE);
                    }
                }
            }
        }

        return $resp;
    }

    protected function getUserByReferralCode($code, $application_id){
        return AppUser::where('application_id',$application_id)
                        ->where('referral_code',$code)
                        ->first();
    }

    protected function generateUniqueReferralCode($application_id,$length){
        $code = null;
        do{
            $code = Helper::generateRandomString($length);
            $u = $this->getUserByReferralCode($code,$application_id);

            if($u!=null){
                $code = null;
            }
        }while($code === null);
        return $code;
    }

    protected function checkUniqueness(AppResponse $resp, $data, $application_id, $currentUser = null){
        $username = Helper::getWithDefault($data,'username');
        $email = Helper::getWithDefault($data,'email');
        $query = AppUser::where('application_id', $application_id)
            ->where('username', $username);

        if (!empty($email)) {
            $query = $query->orWhere('email', $email);
        }

        $d = $query->first();

        if($d!=null){
            if (($currentUser == null && $d->username == $username) || ($currentUser!=null && $currentUser->id != $d->id))
                $resp->addError('username', 'Username already registered', ErrorCodes::$USERNAME_EXISTS);
            if ((($d->email == $email && $currentUser == null) || ($currentUser!=null && $currentUser->id != $d->id)) && !empty($email))
                $resp->addError('email', 'Email already registered', ErrorCodes::$EMAIL_EXISTS);
        }

        return $d;
    }

    public function createUpdateUser($data, $appUser = null, $application_id = null) {
        $resp = new AppResponse(true);
        $validator = Validator::make($data, AppUser::creationUpdateRules());

        $username = Helper::getWithDefault($data,'username');
        $email = Helper::getWithDefault($data,'email');
        $country = Helper::getWithDefault($data, 'country');
        $referralCodeLength = Helper::getWithDefault($data, 'referral_code_length', 6);
        $referralCode = Helper::getWithDefault($data,'referral_code',null);
        $reward_pending_referrals = Helper::getWithDefault($data,'reward_pending_referrals',null);

        if ($validator->passes()) {
            if ($appUser != null) {
                $appUser = AppUser::firstOrNew([
                    'id' => $appUser->id
                ]);
                $application_id = $appUser->application_id;
                $this->checkUniqueness($resp,$data,$application_id,$appUser);
                if(!$resp->getStatus()){
                    $appUser = null;
                }else{
                    $reward_pending_referrals = $reward_pending_referrals === null ? $appUser->reward_pending_referrals : $reward_pending_referrals;
                }
            } else {
                $this->checkUniqueness($resp,$data,$application_id);
                if($resp->getStatus()) {
                    $appUser = new AppUser();
                    $appUser->api_token = $this->createNewToken();
                    $appUser->created_at = time();
                    $appUser->total_referrals = 0;
                    $appUser->referral_code = $this->generateUniqueReferralCode($application_id,$referralCodeLength);
                }
            }

            if ($appUser != null) {
                $resp = $this->processSocialData($data,$application_id);
                $referredUser = null;

                if($referralCode!==null){
                    $referredUser = $this->getUserByReferralCode($referralCode,$application_id);
                    if($referredUser===null){
                        $resp->addError('referral_code','Invalid referral code', ErrorCodes::$INVALID_REFERRAL_CODE);
                    }
                }

                if($resp->getStatus()) {
                    $resp->setStatus(false);

                    if ($country == null) {
                        $ip = request()->ip();
                        $country = Helper::getIpLocation($ip);
                    }

                    $appUser->username = $username;
                    $appUser->email = $email;
                    $appUser->reward_pending_referrals = $reward_pending_referrals;
                    $appUser->first_name = Helper::getWithDefault($data, 'first_name');
                    $appUser->last_name = Helper::getWithDefault($data, 'last_name');
                    $appUser->application_id = $application_id;
                    $appUser->fbid = Helper::getWithDefault($data, 'fbid', $appUser->fbid);
                    $appUser->gender = Helper::getWithDefault($data, 'gender');
                    $appUser->country = $country;
                    $appUser->extra = Helper::getWithDefault($data, 'extra');
                    $password = Helper::getWithDefault($data, 'password', '');
                    if (!empty($password)) {
                        $appUser->password = Hash::make($password);
                    }
                    $appUser->save();

                    $resp->data = $appUser;
                    $resp->setStatus(true);
                    $appUser->api_token = null;

                    if($referredUser!==null){
                        $referredUser->total_referrals++;
                        $referredUser->reward_pending_referrals++;
                        $referredUser->save();
                    }
                }
            }
        }

        $resp->addErrorsFromValidator($validator);
        return $resp;
    }

    public function loginRegisterWithFacebook($data, $application_id){
        $resp = $this->processSocialData($data,$application_id);

        if($resp->getStatus()){
            $fbid = Helper::getWithDefault($data,'fbid','iqwneio');
            $user = AppUser::where('fbid',$fbid)->first();

            if($user!=null) {
                $resp = $this->getUserForLogin($user->id);
            } else {
                $resp = $this->createUpdateUser($data, null, $application_id);
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