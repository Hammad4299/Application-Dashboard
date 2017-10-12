<?php
namespace App\Http\Controllers\Api\MoneyMaker;

use App\Models\ModelAccessor\AppUserScoreAccessor;
use App\Models\ModelAccessor\LeaderboardAccessor;


/**
 * Created by PhpStorm.
 * User: talha
 * Date: 3/29/2017
 * Time: 7:21 PM
 */
class LeaderboardController extends \App\Http\Controllers\Api\LeaderboardController
{
    public function __construct(AppUserScoreAccessor $scoreAccessor,LeaderboardAccessor $leaderboardAccessor)
    {
        parent::__construct($scoreAccessor,$leaderboardAccessor);
    }

    /**
     * @api {POST} moneymaker/leaderboard Create Application Leaderboard
     * @apiGroup AppLeaderboard (MoneyMaker)
     * @apiVersion 0.1.0
     * @apiUse LeaderboardCreateCommon
     * @apiUse queuedSupport
     * @apiUse authApp
     * @apiUse errorUnauthorized
     */

    /**
     * @api {Get} moneymaker/leaderboard/:leaderboard_id Get Leaderboard Score
     * @apiGroup AppLeaderboard (MoneyMaker)
     * @apiVersion 0.1.0
     * @apiUse LeaderboardGetCommon
     * @apiUse authApp
     * @apiUse errorUnauthorized
     */

    /**
     * @api {POST} moneymaker/leaderboard/:leaderboard_id/score Update User Score
     * @apiGroup AppLeaderboard (MoneyMaker)
     * @apiVersion 0.1.0
     * @apiUse LeaderboardUpdateScoreCommon
     * @apiUse authUser
     * @apiUse queuedSupport
     * @apiUse errorUnauthorized
     */
}