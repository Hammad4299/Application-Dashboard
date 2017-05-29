<?php

namespace App\Models\ModelAccessor;


use App\Classes\AppResponse;
use App\Models\AppLeaderboard;
use App\Models\Application;
use App\Models\AppUserScore;
use App\Validator\ErrorCodes;
use Illuminate\Support\Facades\Validator;

class AppUserScoreAccessor extends BaseAccessor
{
    //Not supposed to be called from controller
    public function getUserScoreWithRank($leaderboardid, $user_id){
         return AppUserScore::rank($leaderboardid)
            ->where('app_user_id',$user_id)
             ->first();
    }

    public function updateScore($data, $board_id, $user){
        $leaderboardAccessor = new LeaderboardAccessor();
        $validator = Validator::make($data,AppUserScore::scoreUpdateRules());
        $resp = new AppResponse(false);
        $board = $leaderboardAccessor->getLeaderboard($board_id,$user->application_id);
        if($board!=null){
            $resp->setStatus(true);
        }else{
            $resp->addError('leaderboard_id',"user cannot access this leaderboard",ErrorCodes::$USER_LEADERBOARD_ACCESS_UNAUTHORIZED);
        }

        if($resp->getStatus()){
            $score = AppUserScore::firstOrNew([
                'leaderboard_id' => $board_id,
                'app_user_id' => $user->id
            ]);
            $score->leaderboard_id = $board_id;
            $score->app_user_id = $user->id;
            $score->application_id = $user->application_id;
            $score->score = $data['score'];
            $score->modified_at = time();
            $score->save();
            $resp->data = $score;
        }


        $resp->addErrorsFromValidator($validator);
        return $resp;
    }
}