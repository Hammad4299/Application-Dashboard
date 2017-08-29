<?php

namespace App\Http\Controllers\MoneyMaker;

use App\Classes\Helper;
use App\Models\ModelAccessor\AppUserAccessor;
use App\Models\ModelAccessor\ApplicationAccessor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppUserController extends \App\Http\Controllers\AppUserController
{
    public function __construct(AppUserAccessor $accessor){
        parent::__construct($accessor);
        $this->viewPrefix = "moneymaker.";
    }

    public function show(Request $request){
        $application_id = $request->route()->parameter('application_id');
        $params = $request->all();
        $resp = $this->appUserAccessor->getApplicationUsersWithScores($application_id,$params,Helper::getWithDefault($params,'page',1));

        return view($this->viewPrefix.'applications.users.index', ['users' => $resp->data,'application_id'=>$application_id]);
    }

    public function changeState(Request $request){
        $app_user_id = $request->route()->parameter('app_user_id');
        $state = $request->get('state');
        $resp = $this->appUserAccessor->changeUserState($app_user_id,$state);

        return json_encode($resp);
    }

    public function destroy(Request $request){
        $app_user_id = $request->route()->parameter('app_user_id');
        $resp = $this->appUserAccessor->deleteUser($app_user_id);
        return json_encode($resp);
    }
}