<?php

namespace App\Models\ModelAccessor;


use App\Classes\AppResponse;
use App\Models\AppLeaderboard;
use App\Models\Application;
use App\Models\AppUserScore;
use App\Validator\ErrorCodes;
use Illuminate\Pagination\PaginationServiceProvider;
use Illuminate\Support\Facades\Validator;

class LeaderboardAccessor extends BaseAccessor
{
    /**
     * Not secure
     * @param $id
     * @param $application_id
     * @return mixed
     */
    public function getLeaderboard($id,$application_id){
        return AppLeaderboard::where('id',$id)
                ->where('application_id',$application_id)
                ->first();
    }

    public function create($data,$application_id){
        $validator = Validator::make($data,AppLeaderboard::creationRules());
        $resp = new AppResponse(false);

        if($validator->passes()){
            $resp->data = AppLeaderboard::create([
                'name' => $data['name'],
                'application_id' => $application_id
            ]);

            $resp->setStatus(true);
        }

        $resp->addErrorsFromValidator($validator);
        return $resp;
    }

    public function getAppboard($application_id, $leaderboardid, $data){
        $scoreAccessor = new AppUserScoreAccessor();
        $page = 1;
        $perpage = 10;
        $userid = null;
        $resp = new AppResponse(false);
        $validator = Validator::make([],[]);

        if(!empty($data['app_user_id'])){
            $userid = $data['app_user_id'];
        }
        if(!empty($data['perpage'])){
            $perpage = $data['perpage'];
        }
        if(!empty($data['page'])){
            $page = $data['page'];
        }

        $offset = ($page-1)*$perpage;

        $board = AppLeaderboard::with(['scores'=>function($query2) use($leaderboardid,$offset,$perpage){
                $query2->rank($leaderboardid)
                    ->skip($offset)
                    ->limit($perpage);
        }])
        ->where('id',$leaderboardid)
        ->where('application_id',$application_id)
        ->first();

        if($board == null){
            $resp->addError('leaderboard_id',"Bad request",ErrorCodes::$LEADERBOARD_NOT_FOUND);
        }else{
            $resp->setStatus(true);
            $me = null;
            if($userid!=null){
                $me = $scoreAccessor->getUserScoreWithRank($leaderboardid,$userid);
            }
            $resp->data = [
                'board'=>$board,
                'me'=>$me
            ];
        }

        $resp->addErrorsFromValidator($validator);
        return $resp;
    }
}