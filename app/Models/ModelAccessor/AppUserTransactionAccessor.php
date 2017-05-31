<?php

namespace App\Models\ModelAccessor;


use App\Classes\AppResponse;
use App\Models\AppLeaderboard;
use App\Models\Application;
use App\Models\AppUser;
use App\Models\AppUserScore;
use App\Models\AppUserTransaction;
use App\Validator\ErrorCodes;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AppUserTransactionAccessor extends BaseAccessor
{
    public function create($data, AppUser $user){
        $resp = new AppResponse(true);
        $data['application_id'] = $user->application_id;
        $data['app_user_id'] = $user->id;
        $data['request_time'] = Carbon::now()->getTimestamp();
        $data['updated_at'] = Carbon::now()->getTimestamp();
        $data['status'] = AppUserTransaction::$STATUS_PENDING;
        $validator = Validator::make($data,AppUserTransaction::creationUpdateRules());
        if($validator->passes()){
            DB::beginTransaction();
            $resp->data = AppUserTransaction::create($data);

            $accessor = new AppUserScoreAccessor();
            $r2 = new AppResponse(true);
            $leaderboard_id = self::getWithDefault($data,'leaderboard_id');
            $newScore = self::getWithDefault($data,'score');
            if(!empty($leaderboard_id) && $newScore!==null){
                $r2 = $accessor->updateScore($data,$leaderboard_id,$user);
            }

            $resp->mergeErrors($r2->errors);
            if($resp->getStatus()){
                DB::commit();
            }else{
                DB::rollback();
            }
        }

        $resp->addErrorsFromValidator($validator);
        return $resp;
    }

    public function getUserTransactions(AppUser $user){
        $resp = new AppResponse(true);
        $resp->data = AppUserTransaction
            ::where('application_id',$user->application_id)
            ->where('app_user_id',$user->id)
            ->get();
        return $resp;
    }

    public function getApplicationTransactions(Application $app){
        $resp = new AppResponse(true);
        $resp->data = AppUserTransaction::where('application_id',$app->id)->get();
        return $resp;
    }

    public function updateStatus($id, Application $app, $status){
        $resp = new AppResponse(true);
        AppUserTransaction::where('id',$id)
            ->where('application_id',$app->id)
            ->update([
                'updated_at'=>Carbon::now()->getTimestamp(),
                'status'=>$status
            ]);
        return $resp;
    }
}