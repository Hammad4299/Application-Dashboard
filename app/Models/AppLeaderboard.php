<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppLeaderboard extends Model
{
    protected $table = 'app_leaderboards';
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
        'application_id'
    ];

    public $timestamps = false;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public function scores(){
        return $this->hasMany(AppUserScore::class,'leaderboard_id');
    }
}
