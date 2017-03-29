<?php
namespace App\Http\Controllers\Api;
use App\Classes\AuthHelper;
use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\ModelAccessor\ApplicationAccessor;
use App\Models\ModelAccessor\AppUserAccessor;
use App\Models\ModelAccessor\LeaderboardAccessor;
use Illuminate\Http\Request;

/**
 * Created by PhpStorm.
 * User: talha
 * Date: 3/29/2017
 * Time: 7:21 PM
 */
class AppUserController extends Controller
{
    protected $appuserAccessor;
    public function __construct()
    {
        $this->appuserAccessor = new AppUserAccessor();
        $this->middleware('authcheck:appapi',['only'=>['create','login']]);
        $this->middleware('authcheck:app-user-api',['except'=>['create','login']]);
    }

    public function login(Request $request){
        $resp = $this->appuserAccessor->login(AuthHelper::AppAuth()->user()->id,$request->all());
        return response()->json($resp);
    }

    public function create(Request $request){
        $resp = $this->appuserAccessor->createUpdateUser($request->all(),null,AuthHelper::AppAuth()->user()->id);
        return response()->json($resp);
    }

    public function update(Request $request){
        $resp = $this->appuserAccessor->createUpdateUser($request->all(), AuthHelper::AppUserAuth()->user(), null);
        return response()->json($resp);
    }

    public function getMe(Request $request){
        $resp = $this->appuserAccessor->getUserWithScore(AuthHelper::AppUserAuth()->user()->id);
        return response()->json($resp);
    }
}