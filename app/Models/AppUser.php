<?php

namespace App\Models;

use App\Validator\ErrorCodes;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @api {None} gender-enum Gender (Application User)
 * @apiGroup Enums
 * @apiParam (Code) {Integer} 1 Male
 * @apiParam (Code) {Integer} 0 Female
 */
class AppUser extends Authenticatable
{
    public static function creationUpdateRules()
    {
        return [
            'username'=>"required:error_code," . ErrorCodes::$USERNAME_REQUIRED
        ];
    }

    public static function loginRules(){
        return [
            'username'=>"required:error_code," . ErrorCodes::$USERNAME_REQUIRED,
            'password'=>'required:error_code,'.ErrorCodes::$PASSWORD_REQUIRED
        ];
    }

    protected $table = 'app_users';
    public static $GENDER_MALE = 1;
    public static $GENDER_FEMALE = 0;

    public static $STATE_BLOCKED = 1;
    public static $STATE_ACTIVE = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'first_name',
        'last_name',
        'gender',
        'application_id',
        'api_token',
        'country',
        'extra',
        'created_at',
        'fbid'
    ];

    protected $appends = [
        'gender_string'
    ];

    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'fbid'
    ];

    public function getGenderStringAttribute()
    {
        $g = "";
        if($this->gender == AppUser::$GENDER_MALE){
            $g = "Male";
        }elseif($this->gender === AppUser::$GENDER_FEMALE){
            $g = "Female";
        }

        return $g;
    }

    public function scopeLeaderboards($query){
        $query->with(['scores' => function($query2){
            $query2->with('leaderboard');
        }]);
    }

    public function scores(){
        return $this->hasMany(AppUserScore::class,'app_user_id');
    }
}
