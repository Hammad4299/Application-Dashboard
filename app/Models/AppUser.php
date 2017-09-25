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
    use ModelTrait;
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

    public function getIngotScoreAttribute(){
        $score = null;
        if($this->isRelationLoaded('scores')){
            $score = $this->findScore($this,config('moneymaker.leaderboards.ingot.id'));
        }

        return $score === null ? 0 : $score->score;
    }

    public function getCoinScoreAttribute(){
        $score = null;
        if($this->isRelationLoaded('scores')){
            $score = $this->findScore($this,config('moneymaker.leaderboards.coin.id'));
        }

        return $score === null ? 0 : $score->score;
    }

    public function findScore($data,$lb_id){
        return $data->scores->where('leaderboard_id',$lb_id)->first();
    }

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

    public function scopeFilter($query, $filter = []) {
        if(isset($filter['exact_username'])){
            $query = $query->where('username',$filter);
        }

        return $query;
    }

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
