<?php

namespace App\Models\ModelAccessor;
use App\Classes\AppResponse;
use App\Classes\Helper;
use App\Events\SendConfirmationMail;
use App\Models\AppUser;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserAccessor extends BaseAccessor
{
    public function registerUser($data){
        $resp = new AppResponse(true);
        $user = new User($data);

        if($resp->validate($user,$data,['register'=>true])){
            $confirmation_text = Helper::generateRandomString(40);
            $data = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'confirmation_hash' => $confirmation_text,
                'account_status' => User::$STATUS_PENDING
            ]);

            event(new SendConfirmationMail($data));
            $resp->data = $data;
        }

        return $resp;
    }

    public function getUserByCredential($data){
        $resp = new AppResponse(true);
        $user = new User();
        if($resp->validate($user,$data,['login'=>true])) {
            $user = User::where(['email'=>$data['email']])->first();
            if($user == null)
                $user = new User();
            if($resp->validate($user,$data,['loginCred'=>true])) {
                $resp->data = $user;
            }
        }

        return $resp;
    }

    public function getUser($userid, $onlyEssential = true){
        $resp = new AppResponse(true);
        $query = User::query();
        if($onlyEssential)
            $query = $query->userBareMinimum();
        $query->where('id',$userid);
        $resp->data = $query->first();
        return $resp;
    }

    public function getUserByEmail($email){
        $response = new AppResponse(true);
        $user = User::where('email', $email)
            ->first();
        if($user)
            $response->data = $user;

        return $response;
    }

    public function saveUserInformation($data, $user_id){
        $response = new AppResponse(true);
        $nameValidator = Validator::make($data, User::$profileRules['nameRules']);
        $passwordValidator = Validator::make($data, User::$profileRules['passwordRules']);
        $user = User::where('id', $user_id)->first();

        if(!empty($data['password']) || !empty($data['password_confirmation']) || !empty($data['old_password'])) {
            if(!Hash::check($data['old_password'],$user->password)) {
                $response->addError('old_password',__('messages.old_incorrect_password'));
                $response->addErrorsFromValidator($passwordValidator);
            }
        }

        if($response->getStatus()) {
            if (!$nameValidator->passes()) {
                $response->addErrorsFromValidator($nameValidator);
            }
            if (!$passwordValidator->passes()) {
                $response->addErrorsFromValidator($passwordValidator);
            }
            if($response->getStatus()) {
                $user->name = $data['name'];

                if (!empty($data['password']))
                    $user->password = $data['password'];

                $user->save();
                $response->data = $user;
            }
        }

        return $response;
    }

    public function saveResetPassword($data,$email){
        $response = new AppResponse(true);
        $validator = Validator::make($data, User::$profileRules['passwordRules']);

        if($email != null){
            if ($validator->passes()){
                $user = User::where('email', $email)
                    ->first();

                $user->password = Hash::make($data['password']);
                $user->save();

                $pAccessor = new PasswordResetAccessor();
                $pAccessor->clearHashes($email);
                $response->data = $user;
            }else{
                $response->addErrorsFromValidator($validator);
            }
        }

        return $response;
    }

    public function updateUserConfirmation($confirmation_hash){
        $response = new AppResponse(true);
        $user = User::where('confirmation_hash', $confirmation_hash)->first();

        if($user!=null){
            $user->confirmation_hash = null;
            $user->account_status = User::$STATUS_EMAIL_CONFIRMED;
            $user->save();
        }

        $response->data = $user;
        return $response;
    }
}