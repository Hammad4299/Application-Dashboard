<?php

namespace App\Models\ModelAccessor;


use App\Classes\AppResponse;
use App\Models\AppLeaderboard;
use App\Models\Application;
use App\Models\AppUserScore;
use Illuminate\Pagination\PaginationServiceProvider;
use Illuminate\Support\Facades\Validator;

class LeaderboardAccessor extends BaseAccessor
{
    public function getLeaderboard($id,$application_id){
        return AppLeaderboard::where('id',$id)
                ->where('application_id',$application_id)
                ->first();
    }

    public function create($data,$application_id){
        $validator = Validator::make($data,AppLeaderboard::$CREATION_RULES);
        $resp = new AppResponse(false);

        if($validator->passes()){
            $resp->data = AppLeaderboard::create([
                'name' => $data['name'],
                'application_id' => $application_id
            ]);

            $resp->status = true;
        }

        $resp->setValidator($validator);
        return $resp;
    }

    public function getAppboard($application, $leaderboardid, $data){
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
        ->where('application_id',$application->id)
        ->first();

        if($board == null){
            $validator->errors()->add('leaderboard_id','Bad request');
        }else{
            $resp->status = true;
            $me = null;
            if($userid!=null){
                $me = $scoreAccessor->getUserScoreWithRank($leaderboardid,$userid);
            }
            $resp->data = [
                'board'=>$board,
                'me'=>$me
            ];
        }

        $resp->setValidator($validator);
        return $resp;
    }
}