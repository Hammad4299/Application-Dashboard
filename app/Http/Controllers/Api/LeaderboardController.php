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
    public function __construct()
    {
        $this->scoreAccessor = new AppUserScoreAccessor();
        $this->leaderboardAccessor = new LeaderboardAccessor();
        $this->middleware('authcheck:appapi',['except'=>['updateScore']]);
        $this->middleware('authcheck:app-user-api',['only'=>['updateScore']]);
    }

    /**
     * @api {POST} application/leaderboard Create Application Leaderboard
     * @apiGroup AppLeaderboard
     * @apiVersion 0.1.0
     * @apiUse queuedSupport
     * @apiDescription Create a new Leaderboard in specified Application
     * @apiParam (form) {String} name Name of leaderboard
     * @apiSuccess (Success) {Response(AppLeaderboard)} Body
     * @apiUse authApp
     * @apiUse errorUnauthorized
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request){
        $resp = $this->leaderboardAccessor->create($request->all(),AuthHelper::AppAuth()->user()->id);
        $this->leaderboardAccessor->onComplete($resp,$request->all(),AuthHelper::AppAuth()->user()->id);
        return response()->json($resp);
    }

    /**
     * @api {Get} application/leaderboard/:leaderboard_id Get Leaderboard Score
     * @apiGroup AppLeaderboard
     * @apiVersion 0.1.0
     * @apiParam (query) {Integer} [perpage=10] How many top scores to return.
     * @apiParam (query) {Integer} [page=1] Which page to get.
     * @apiParam (query) {Integer} [app_user_id=null] User whose rank must be returned.
     * @apiSuccess (Success) {Response(LeaderboardScoreWithRank)} Body
     * @apiUse authApp
     * @apiUse errorUnauthorized
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLeaderboardScores(Request $request,$leaderboard_id){
        $application = AuthHelper::AppAuth()->user();
        $resp = $this->leaderboardAccessor->getAppboard($application->id,$leaderboard_id,$request->all());
        return response()->json($resp);
    }

    /**
     * @api {POST} application/leaderboard/:leaderboard_id/score Update User Score
     * @apiGroup AppLeaderboard
     * @apiVersion 0.1.0
     * @apiDescription Update user score in leaderboard with id :leaderboard_id
     * @apiUse queuedSupport
     * @apiParam (form) {Integer} score New score
     * @apiSuccess (Success) {Response(AppUserScore)} Body
     * @apiUse authUser
     * @apiUse errorUnauthorized
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateScore(Request $request,$leaderboard_id){
        $resp = $this->scoreAccessor->updateScore($request->all(),$leaderboard_id,AuthHelper::AppUserAuth()->user()->id,AuthHelper::AppUserAuth()->user()->application_id);
        $this->leaderboardAccessor->onComplete($resp,$request->all(),AuthHelper::AppUserAuth()->user()->application_id);
        return response()->json($resp);
    }
}