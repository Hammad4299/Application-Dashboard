<?php
namespace App\Http\Controllers\Api;
use App\Classes\AuthHelper;
use App\Http\Controllers\Controller;
use App\Models\ModelAccessor\AppUserScoreAccessor;
use App\Models\ModelAccessor\LeaderboardAccessor;
use Illuminate\Http\Request;

/**
 * Created by PhpStorm.
 * User: talha
 * Date: 3/29/2017
 * Time: 7:21 PM
 */
class LeaderboardController extends Controller
{
    /**
     * @var LeaderboardAccessor
     */
    protected $leaderboardAccessor;
    /**
     * @var AppUserScoreAccessor
     */
    protected $scoreAccessor;
    public function __construct(AppUserScoreAccessor $scoreAccessor,LeaderboardAccessor $leaderboardAccessor)
    {
        $this->scoreAccessor = $scoreAccessor;
        $this->leaderboardAccessor = $leaderboardAccessor;
        $this->middleware('authcheck:appapi',['except'=>['updateScore']]);
        $this->middleware('authcheck:app-user-api',['only'=>['updateScore']]);
    }

    /**
     * @api {POST} application/leaderboard Create Application Leaderboard
     * @apiGroup AppLeaderboard (General)
     * @apiVersion 0.1.0
     * @apiUse LeaderboardCreateCommon
     * @apiUse queuedSupport
     * @apiUse authApp
     * @apiUse errorUnauthorized
     */
    public function create(Request $request){
        $resp = $this->leaderboardAccessor->create($request->all(),AuthHelper::AppAuth()->user()->id);
        $this->leaderboardAccessor->onComplete($resp,$request->all(),AuthHelper::AppAuth()->user()->id);
        return response()->json($resp);
    }

    /**
     * @api {Get} application/leaderboard/:leaderboard_id Get Leaderboard Score
     * @apiGroup AppLeaderboard (General)
     * @apiVersion 0.1.0
     * @apiUse LeaderboardGetCommon
     * @apiUse authApp
     * @apiUse errorUnauthorized
     */
    public function getLeaderboardScores(Request $request,$leaderboard_id){
        $application = AuthHelper::AppAuth()->user();
        $resp = $this->leaderboardAccessor->getLeaderboardWithRanks($application->id,$leaderboard_id,$request->all());
        return response()->json($resp);
    }

    /**
     * @api {POST} application/leaderboard/:leaderboard_id/score Update User Score
     * @apiGroup AppLeaderboard (General)
     * @apiVersion 0.1.0
     * @apiUse LeaderboardUpdateScoreCommon
     * @apiUse authUser
     * @apiUse queuedSupport
     * @apiUse errorUnauthorized
     */
    public function updateScore(Request $request,$leaderboard_id){
        $resp = $this->scoreAccessor->updateScore($request->all(),$leaderboard_id,AuthHelper::AppUserAuth()->user()->id,AuthHelper::AppUserAuth()->user()->application_id);
        $this->leaderboardAccessor->onComplete($resp,$request->all(),AuthHelper::AppUserAuth()->user()->application_id);
        return response()->json($resp);
    }
}