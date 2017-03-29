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

    public function create(Request $request){
        $resp = $this->leaderboardAccessor->create($request->all(),AuthHelper::AppAuth()->user()->id);
        return response()->json($resp);
    }

    public function getLeaderboardScores(Request $request,$leaderboard_id){
        $application = AuthHelper::AppAuth()->user();
        $resp = $this->leaderboardAccessor->getAppboard($application,$leaderboard_id,$request->all());
        return response()->json($resp);
    }

    public function updateScore(Request $request,$leaderboard_id){
        $resp = $this->scoreAccessor->updateScore($request->all(),$leaderboard_id,AuthHelper::AppUserAuth()->user());
        return response()->json($resp);
    }
}