<?php

namespace App\Models;

use App\Validator\ErrorCodes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AppUserScore extends Model
{
    public static function scoreUpdateRules (){
        return [
            'score'=>'required:error_code,'.ErrorCodes::$SCORE_VALUE_REQUIRED_REQUIRED
        ];
    }

    protected $table = 'app_users_scores';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'score',
        'application_id',
        'app_user_id',
        'modified_at',
        'leaderboard_id'
    ];

    public function scopeRank($query, $board_id){
        DB::select(DB::raw("Select @rank := 0"));
        $builder = "(".DB::table('app_users_scores')
            ->whereRaw("leaderboard_id = $board_id")
            ->orderBy('score','desc')
            ->selectRaw('*, @rank := @rank + 1 as rank')
            ->toSql().") as app_users_scores";


        $query->from(DB::raw($builder));
        return $query;
    }

    public $timestamps = false;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'api_token'
    ];

    public function application(){
        return $this->belongsTo(Application::class,'application_id');
    }

    public function appuser(){
        return $this->belongsTo(AppUser::class,'app_user_id');
    }

    public function leaderboard(){
        return $this->belongsTo(AppUser::class,'leaderboard_id');
    }
}
