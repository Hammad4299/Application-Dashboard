<?php

namespace App\ViewComposers;

use App\Models\ModelsAccessor\FacebookAccountsAccessor;
use App\Models\ModelsAccessor\UserAccessor;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserInfoComposer{
    public function __construct()
    {
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
//        if(Auth::check()){
//            $accessor = new FacebookAccountsAccessor();
//            $userAccount = $accessor->getAccount(Auth::user()->id);
//            $accssor = new UserAccessor();
//            $user = $accssor->userViewEssential(Auth::user()->id);
//
//            $view
//                ->with('userInfo', $user)
//                ->with('userAccount',$userAccount)
//                ->with('viewName',$view->getName());
//        }
    }
}