<?php

namespace App\Models;

use App\Classes\AppResponse;
use App\Validator\IValidatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class User extends Authenticatable implements IValidatable
{
    public static $STATUS_PENDING = 0;
    public static $STATUS_EMAIL_CONFIRMED = 1;
    public $table = 'users';
    use Notifiable,ModelTrait;

    public static $registration_rules = [
        "email" => 'required|email|unique:users',
        "name" => 'required',
        "password" => "required|confirmed|min:6"
    ];

    public static $login_rules = [
        "email" => 'required|email',
        "password" => "required|min:6"
    ];

    public static $profileRules = [
        'nameRules' => [
            'name' => 'required|min:6'
        ],
        'passwordRules' => [
            'password' => 'confirmed'
        ]
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'confirm_password', 'confirmation_hash', 'account_status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $appends = [
        'user_image_url'
    ];

    public $timestamps = false;

    public function getUserImageUrlAttribute(){
        return URL::asset('images/dummy-user-image.png');
    }

    public function scopeUserBareMinimum($query){
        return $query
            ->select('name','id','email');
    }

    /**
     * @param array $options
     * @param array $input
     * @return \Illuminate\Validation\Validator
     */
    public function validate($options = [], $input = [])
    {
        $validator = null;
        if(isset($options['register']) && $options['register'] == true){
            $validator = Validator::make($input,User::$registration_rules);
        }
        if(isset($options['login']) && $options['login']==true){
            $validator = Validator::make($input,User::$login_rules);
        }
        if(isset($options['loginCred']) && $options['loginCred']==true){
            $validator = Validator::make([],[]);

            if(!Hash::check($input['password'],$this->password)){
                AppResponse::addErrorInBag($validator->errors(),'password',__('messages.incorrect_password'));
            }

            if(empty($this->email)){
                AppResponse::addErrorInBag($validator->errors(),'email',__('messages.email_not_registered'));
            }
        }

        return $validator;
    }
}
