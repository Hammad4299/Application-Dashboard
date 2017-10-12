<?php

namespace App\Models\ModelAccessor;
use App\Classes\AppResponse;
use App\Classes\Helper;
use App\Events\AppUserDeleted;
use App\Http\Controllers\Api\AppUserController;
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

    public function getAppUser($id){
        $resp = new AppResponse();
        $app = AppUser::where('id',$id)->first();
        $resp->data = $app;
        $resp->setStatus(true);
        return $resp;
    }

    public function getApplicationUsersWithScores($application_id, $filters = [],$options = []){
        $resp = new AppResponse(true);
        $query = AppUser::where('application_id',$application_id)->filter($filters)->with('scores');
        $resp->data = $query->queryData($options);
        return $resp;
    }

    protected function fillSocialOAuthLoginData(&$data, $application_id, $types = null){
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

    /**
     * Checks user uniqueness for update or creation
     * @param AppResponse $resp
     * @param $data
     * @param $application_id
     * @param null $currentUser
     * @return mixed
     */
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

    /**
     * @param $data
     * @param AppResponse $resp This gets filled with any errors
     * @param AppUser|null $appUser
     * @param null $application_id
     * @return AppUser|null
     */
    protected function getAppUserForCreationOrUpdation($data,AppResponse $resp,&$isEdit,AppUser $appUser = null,$application_id = null){
        if ($appUser != null) { //Edit
            $isEdit = true;
            $appUser = AppUser::firstOrNew(['id' => $appUser->id]);
            $application_id = $appUser->application_id;
            $this->checkUniqueness($resp,$data,$application_id,$appUser);
            if(!$resp->getStatus()){
                $appUser = null;
            }
        } else {
            $this->checkUniqueness($resp,$data,$application_id);
            if($resp->getStatus()) {
                $appUser = new AppUser();
                $appUser->api_token = $this->createNewToken();
                $appUser->created_at = time();
            }
        }
        return $appUser;
    }

    public function createUpdateUser($data, $appUser = null, $application_id = null) {
        $resp = new AppResponse(true);
        $validator = Validator::make($data, AppUser::creationUpdateRules());

        $isEdit = false;
        $username = Helper::getWithDefault($data,'username');
        $email = Helper::getWithDefault($data,'email');
        $country = Helper::getWithDefault($data, 'country');
        if($validator->passes()) {
            $appUser = $this->getAppUserForCreationOrUpdation($data,$resp,$isEdit,$appUser,$application_id);

            if ($appUser != null) {
                $resp = $this->fillSocialOAuthLoginData($data, $application_id);

                if ($resp->getStatus()) {
                    $resp->setStatus(false);
                    $appUser->username = $username;
                    $appUser->email = $email;
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

                    $this->createOrUpdate($resp, $appUser, $isEdit,$data);
                }
            }
        }

        $resp->addErrorsFromValidator($validator);
        return $resp;
    }

    protected function createOrUpdate(AppResponse $resp,AppUser $appUser,$isEdit,$data){
        if ($this->validateBeforeSave($resp, $appUser, $isEdit)) {
            $appUser->save();
            $resp->data = $appUser;
            $resp->setStatus(true);
            $appUser->api_token = null;
        }
    }

    protected function validateBeforeSave(AppResponse $resp, AppUser $user,$isEdit){
        return true;
    }

    protected function getUserOnLoginAuthentication($user_id){
        $resp = $this->getUserWithScore($user_id);
        return AppUserController::processAppResponseForLogin($resp);
    }

    public function loginRegisterWithFacebook($data, $application_id){
        $resp = $this->fillSocialOAuthLoginData($data,$application_id);

        if($resp->getStatus()){
            $fbid = Helper::getWithDefault($data,'fbid','iqwneio');
            $user = AppUser::where('fbid',$fbid)->first();

            if($user!=null) {
                $resp = $this->getUserWithScore($user->id);
            } else {
                $resp = $this->createUpdateUser($data, null, $application_id);
            }
        }

        return $resp;
    }

    public function login($application_id, $data){
        $resp = new AppResponse();
        $validator = Validator::make($data,AppUser::loginRules());

        if($validator->passes()){
            $user = AppUser::where('application_id',$application_id)
                ->where('username',$data['username'])
                ->first();

            if($user!=null && Hash::check($data['password'],$user->password)){
                $resp = $this->getUserOnLoginAuthentication($user->id);
            } else {
                $resp->addError('password','Invalid username or password',ErrorCodes::$INCORRECT_LOGIN_CREDENTIALS);
            }
        }

        $resp->addErrorsFromValidator($validator);
        return $resp;
    }

    public function changeUserState($app_user_id,$application_id,$state){
        $resp = new AppResponse();
        $user = AppUser::where('id',$app_user_id)->where('application_id',$application_id);
        switch($state)
        {
            case AppUser::$STATE_ACTIVE:
            case AppUser::$STATE_BLOCKED:
                $user = $user->update(['state'=>$state]);
                break;
        }

        return $resp;
    }
    //to delete app user
    public function deleteUser($app_user_id,$application_id){
        $resp = new AppResponse();
        $user = AppUser::where('id',$app_user_id)
            ->where('application_id',$application_id)
            ->delete();
        event(new AppUserDeleted($app_user_id));
        return $resp;
    }
}