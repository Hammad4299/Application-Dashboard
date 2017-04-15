<?php

namespace App\Models\ModelAccessor;


use App\Classes\AppResponse;
use App\Models\AppUser;
use App\Validator\ErrorCodes;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AppUserAccessor extends BaseAccessor
{
    public function getUserWithScore($app_user_id){
        $resp = new AppResponse(true);
        $resp->data = AppUser::where('id',$app_user_id)->leaderboards()->first();
        return $resp;
    }

    public function createUpdateUser($data, $appUser = null, $application_id = null){
        $validator = Validator::make($data, AppUser::creationUpdateRules());
        $resp = new AppResponse();

        if($validator->passes()){
            if($appUser != null){
                $appUser = AppUser::firstOrNew([
                    'id'=>$appUser->id
                ]);
                $application_id = $appUser->application_id;
            }else{
                $query = AppUser::where('application_id',$application_id)
                    ->where('username',$data['username']);

                if(!empty($data['email'])){
                    $query = $query->orWhere('email',$data['email']);
                }

                $d = $query->first();
                if($d==null){
                    $appUser = new AppUser();
                    $appUser->api_token = $this->createNewToken();
                    $appUser->username = $data['username'];
                    $appUser->created_at = time();
                }else{
                    if($d->username == $data['username'])
                        AppResponse::addError($validator->errors(),'username','Username already registered',ErrorCodes::$USERNAME_EXISTS);
                    if($d->email == $data['email'] && !empty($data['email']))
                        AppResponse::addError($validator->errors(),'email','Email already registered',ErrorCodes::$EMAIL_EXISTS);
                }
            }

            if($appUser != null) {
                $appUser->email = self::getWithDefault($data, 'email');
                $appUser->first_name = self::getWithDefault($data, 'first_name');
                $appUser->last_name = self::getWithDefault($data, 'last_name');
                $appUser->gender = self::getWithDefault($data, 'gender');
                $appUser->application_id = $application_id;
                $appUser->gender = self::getWithDefault($data, 'gender');
                $appUser->country = self::getWithDefault($data, 'country');
                $appUser->extra = self::getWithDefault($data, 'extra');

                $password = self::getWithDefault($data, 'password', '');
                if (!empty($password)) {
                    $appUser->password = Hash::make($password);
                }
                $appUser->save();

                $resp->data = $appUser;
                $resp->status = true;
                $appUser->api_token = null;
            }
        }

        $resp->setValidator($validator);
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
                $resp = $this->getUserWithScore($user->id);
            }else{
                AppResponse::addError($validator->errors(),'password','Invalid username or password',ErrorCodes::$INCORRECT_LOGIN_CREDENTIALS);
            }
        }

        $resp->setValidator($validator);
        return $resp;
    }
}