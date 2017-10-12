<?php

namespace App\Models\ModelAccessor\MoneyMaker;

use App\Classes\AppResponse;
use App\Classes\Helper;
use App\Models\AppUser;
use App\Models\AppUserTransaction;
use App\Models\ModelAccessor\AppUserScoreAccessor;

class AppUserTransactionAccessor extends \App\Models\ModelAccessor\AppUserTransactionAccessor
{
    protected function createTransaction($data,AppResponse $resp,AppUser $user){
        $resp->data = AppUserTransaction::create($data);
        $accessor = new AppUserScoreAccessor();
        $r2 = new AppResponse(true);
        $leaderboard_id = Helper::getWithDefault($data,'leaderboard_id');
        $newScore = Helper::getWithDefault($data,'score');
        if(!empty($leaderboard_id) && $newScore!==null){
            $r2 = $accessor->updateScore($data,$leaderboard_id,$user->id,$user->application_id);
        }

        $resp->mergeErrors($r2->errors);
    }
}