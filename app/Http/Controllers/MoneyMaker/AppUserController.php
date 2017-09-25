<?php

namespace App\Http\Controllers\MoneyMaker;

use App\Applications\MoneyMakerApplication;
use App\Classes\Helper;
use App\Http\Middleware\CanAccessApplicationCheck;
use App\Http\Middleware\RedirectIfNotAuthenticated;
use App\Models\ModelAccessor\AppUserAccessor;
use Illuminate\Http\Request;

class AppUserController extends \App\Http\Controllers\AppUserController
{
    protected $applicationConfig;
    public function __construct(AppUserAccessor $accessor){
        parent::__construct($accessor);
        $this->applicationConfig = MoneyMakerApplication::getInstance();
        $this->viewPrefix = $this->applicationConfig->getViewPrefix();

        $this->middleware(RedirectIfNotAuthenticated::class);
        $this->middleware(CanAccessApplicationCheck::class);
    }

    public function show(Request $request){
        $application_id = $request->route()->parameter('application_id');
        $resp = $this->appUserAccessor->getApplicationUsersWithScores($application_id,$request->all(),[
            'paginate'=>1000,
            'order'=>[
                ['username','asc']
            ]
        ]);
        return view($this->viewPrefix.'applications.users.index', ['users' => $resp->data,'application_id'=>$application_id]);
    }

    public function changeState(Request $request){
        $application_id = $request->route()->parameter('application_id');
        $app_user_id = $request->route()->parameter('app_user_id');
        $state = $request->get('state');
        $resp = $this->appUserAccessor->changeUserState($app_user_id,$application_id,$state);
        return json_encode($resp);
    }

    public function destroy(Request $request){
        $application_id = $request->route()->parameter('application_id');
        $app_user_id = $request->route()->parameter('app_user_id');
        $resp = $this->appUserAccessor->deleteUser($app_user_id,$application_id);
        return json_encode($resp);
    }
}