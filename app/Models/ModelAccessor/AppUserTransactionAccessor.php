<?php

namespace App\Models\ModelAccessor;


use App\Classes\AppResponse;
use App\Classes\Helper;

use App\Models\AppUser;
use App\Models\AppUserTransaction;
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
                $r2 = $accessor->updateScore($data,$leaderboard_id,$user->id,$user->application_id);
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

    public function getApplicationTransactions($application_id, $status = null, $options = []){
        $resp = new AppResponse(true);
        $query = AppUserTransaction::where('application_id',$application_id);
        if($status!=null)
            $query = $query->where('status',$status);

        $query = $query->with('app_users');
        $resp->data = $query->queryData($options);
        return $resp;
    }

    public function updateStatus($id, $application_id, $status){
        $resp = new AppResponse(true);
        AppUserTransaction::where('id',$id)
            ->where('application_id',$application_id)
            ->update([
                'updated_at'=>Carbon::now()->getTimestamp(),
                'status'=>$status
            ]);
        return $resp;
    }

    public function deleteUserTransactions($appuser_id,$application_id){
        $resp = new AppResponse(true);

        $query = AppUserTransaction::where('application_id',$application_id)
            ->where('app_user_id',$appuser_id)->delete();

        return $resp;
    }

}