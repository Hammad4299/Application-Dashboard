<?php

namespace App\Models;

use App\Validator\ErrorCodes;
use Illuminate\Database\Eloquent\Model;

class AppLeaderboard extends Model
{
    use ModelTrait;
    protected $table = 'app_leaderboards';
    public static function creationRules()
    {
        return [
            'name'=>"required:error_code," . ErrorCodes::$LEADERBOARD_NAME_REQUIRED
        ];
    }

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
