<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class AppUser extends Authenticatable
{
    public static $CREATION_UPDATE_RULES = [
        'username'=>'required'
    ];

    protected $table = 'app_users';
    public static $GENDER_MALE = 1;
    public static $GENDER_FEMALE = 0;

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
        'created_at'
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
        'password'
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
