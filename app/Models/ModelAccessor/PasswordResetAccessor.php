<?php

namespace App\Models\ModelAccessor;

use App\Classes\AppResponse;
use App\Classes\Helper;
use App\Mail\ResetPassword;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class PasswordResetAccessor extends BaseAccessor
{
    public function getFromToken($token){
        $response = new AppResponse(true);
        $response->data = PasswordReset::where('token', $token)
                            ->first();
        return $response;
    }

    public function clearHashes($email){
        PasswordReset::where('email',$email)
            ->delete();
    }

    public function sendResetLinkEmail($email){
        $response = new AppResponse(true);
        $validator = Validator::make([],[]);
        $accessor = new UserAccessor();
        $data = $accessor->getUserByEmail($email);
        $data = $data->data;

        if($data != null){
            $token = Helper::generateRandomString(40);
            PasswordReset::create([
                'email' => $data->email,
                'token' => $token,
                'user_id' => $data->id
            ]);

            Mail::to($data->email)
                ->queue(new ResetPassword($token));
        }else{
            $response->addError('email',__('messages.email_not_registered'));
        }

        $response->addErrorsFromValidator($validator);
        return $response;
    }
}