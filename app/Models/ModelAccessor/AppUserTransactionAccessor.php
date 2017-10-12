<?php

namespace App\Models\ModelAccessor;


use App\Classes\AppResponse;


use App\Models\AppUser;
use App\Models\AppUserTransaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AppUserTransactionAccessor extends BaseAccessor
{
    protected function createTransaction($data,AppResponse $resp,AppUser $user){
        $resp->data = AppUserTransaction::create($data);
    }

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
            $this->createTransaction($data,$resp,$user);
            if($resp->getStatus()){
                DB::commit();
            }else{
                DB::rollback();
            }
        }

        $resp->addErrorsFromValidator($validator);
        return $resp;
    }

    public function getUserTransactions(AppUser $user, $queryOptions = []){
        $resp = new AppResponse(true);
        $query = AppUserTransaction::where('application_id',$user->application_id)
                ->where('app_user_id',$user->id);
        $resp->data = $query->queryData($queryOptions);
        return $resp;
    }

    public function getApplicationTransactions($application_id, $status = null, $queryOptions = []){
        $resp = new AppResponse(true);
        $query = AppUserTransaction::where('application_id',$application_id);
        if($status!=null)
            $query = $query->where('status',$status);

        $query = $query->with('app_users');
        $resp->data = $query->queryData($queryOptions);
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