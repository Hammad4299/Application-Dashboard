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
use Illuminate\Support\Facades\Validator;

class AppUserTransactionAccessor extends BaseAccessor
{
    public function create($data, AppUser $user){
        $resp = new AppResponse(false);
        $data['application_id'] = $user->application_id;
        $data['app_user_id'] = $user->id;
        $data['request_time'] = Carbon::now()->getTimestamp();
        $data['updated_at'] = Carbon::now()->getTimestamp();
        $data['status'] = AppUserTransaction::$STATUS_PENDING;
        $validator = Validator::make($data,AppUserTransaction::creationUpdateRules());
        if($validator->passes()){
            $resp->data = AppUserTransaction::create($data);
        }

        $resp->setValidator($validator);
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