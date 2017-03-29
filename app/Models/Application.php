<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $table = 'applications';
    public static $CREATION_RULES = [
        'name'=>'required'
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'api_token',
        'created_at',
        'modified_at'
    ];

    public $timestamps = false;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'api_token'
    ];

    public function appusers(){
        return $this->hasMany(AppUser::class,'application_id');
    }

    public function leaderboards(){
        return $this->hasMany(AppLeaderboard::class,'application_id');
    }

    public function scores(){
        return $this->hasMany(AppUserScore::class,'application_id');
    }
}
