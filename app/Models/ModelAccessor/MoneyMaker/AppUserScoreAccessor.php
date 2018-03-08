<?php

namespace App\Models\ModelAccessor\MoneyMaker;

use App\Models\AppUserScore;
use Illuminate\Support\Facades\DB;


class AppUserScoreAccessor extends \App\Models\ModelAccessor\AppUserScoreAccessor
{
    public function queryForCalcScore() {
        $config = config('moneymaker.leaderboards');
        $query = AppUserScore::groupBy('app_user_id')
                    ->select('app_user_id');

        $correct = false;
        if(isset($config)){
            $coinId = null;
            $ingotId = null;

            if(isset($config['coin']['id'])) {
                $coinId = $config['coin']['id'];
            }

            if(isset($config['ingot']['id'])) {
                $ingotId = $config['ingot']['id'];
            }

            if($coinId!==null && $ingotId!==null){
                $correct = true;
                $query->selectRaw("
                    SUM(
                        (CASE WHEN leaderboard_id = $coinId THEN score ELSE 1000*score END)
                     ) AS calc_score
                ");
            }
        }

        if(!$correct){
            $query->addSelect(DB::raw('SUM(score) as calc_score'));
        }

//        echo json_encode($query->get());
//        die();
        return $query;
    }
}