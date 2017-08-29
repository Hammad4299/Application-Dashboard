<?php

namespace App\Models\ModelAccessor;


use App\Classes\AppResponse;
use App\Classes\Helper;
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
            $leaderboard_id = Helper::getWithDefault($data,'leaderboard_id');
            $newScore = Helper::getWithDefault($data,'score');
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

    public function getUserTransactions(AppUser $user, $options = [], $page_no = null){
        $resp = new AppResponse(true);
        $query = AppUserTransaction::where('application_id',$user->application_id)
                ->where('app_user_id',$user->id);
        if($page_no===null){
            $resp->data = $query->get();
        }else{
            $resp->data = $query->paginate(100);
        }
        return $resp;
    }

    public function getApplicationTransactions(Application $app, $options = [], $page_no = null,$status=1){
        $resp = new AppResponse(true);
        $query = AppUserTransaction::where('application_id',$app->id);

        if($status>=1 && $status<=3)
            $query = $query->where('status',$status);

        $query=$query->with('app_users');

        if($page_no===null){
            $resp->data = $query->get();
        }else{
            $resp->data = $query->paginate(100);
        }
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