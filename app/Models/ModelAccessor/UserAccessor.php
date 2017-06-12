<?php

namespace App\Models\ModelAccessor;

use App\Classes\AppResponse;
use App\Events\SendConfirmationMail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserAccessor extends BaseAccessor
{
    public function login($userData){
        $validator = Validator::make($userData, User::$loginRules);
        $response = new AppResponse(true);

        if($validator->passes()){
            $data = User::where('email', $userData['email'])
                ->first();

            if(!$data){
                $response->addError('email', __('messages.email_not_registered'));
            } else {
                if(Hash::check($userData['password'], $data->password)){
                    $response->data = $data;
                } else {
                    $response->addError('password', __('messages.incorrect_password'));
                }
            }
        }

        $response->addErrorsFromValidator($validator);
        return $response;
    }

    public function register($userData){
        $validator = Validator::make($userData, User::$registerRules);
        $response = new AppResponse(true);
        $confirmation_text = BaseAccessor::generateRandomString(40);
        if($validator->passes()){
            $data = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make($userData['password']),
                'confirmation' => $confirmation_text,
                'status' => User::$STATUS_PENDING
            ]);

            event(new SendConfirmationMail($data));
            $response->data = $data;
        }

        $response->addErrorsFromValidator($validator);
        return $response;
    }

    public function getUserByEmail($email){
        $response = new AppResponse(true);
        $user = User::where('email', $email)
            ->first();
        if($user)
            $response->data = $user;

        return $response;
    }

    public function getUserAndGenerateConfirmationHash($user_id){
        $response = new AppResponse(true);
        $user = User::where('id', $user_id)
            ->first();

        if($user){
            $user->confirmation = self::generateRandomString(40);
            $user->save();
            $response->data = $user;
        }

        return $response;
    }

    public function getUserInformationWithID($user_id){
        $response = new AppResponse(true);
        $user = User::where('id', $user_id)
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
        $user = User::where('confirmation', $confirmation_hash)->first();

        if($user!=null){
            $user->confirmation = null;
            $user->status = User::$STATUS_VERIFIED;
            $user->save();
        }

        $response->data = $user;
        return $response;
    }
}
