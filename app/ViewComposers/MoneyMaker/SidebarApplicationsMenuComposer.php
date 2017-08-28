<?php

namespace App\ViewComposers\MoneyMaker;

use App\Classes\Helper;
use App\Models\Application;
use App\Models\ModelAccessor\ApplicationAccessor;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Lavary\Menu\Collection;
use Lavary\Menu\Menu;

class SidebarApplicationsMenuComposer {
    public $menu;
    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $data = $view->getData();
        $applications = Helper::getWithDefault($data, 'applications');
        $application = Helper::getWithDefault($data, 'application');
        $application_id = Helper::getWithDefault($data, 'application_id');
        $accessor = new ApplicationAccessor();
        $this->menu->make('DashboardNavbar', function ($menu) use ($view,$data,$application,$applications,$accessor){


            $menu->add('Applications', ['route' => 'application.index'])->id('apps');
            if($applications===null){
                $applications = $accessor->getUserApplications(Auth::user()->id)->data;
            }

            foreach ($applications as $app) {
                $menu->find('apps')->add($app->name,
                    ['route' => ['application.show', 'application_id' => $app->id,'application_slug'=>$app->route_prefix]]
                )->id('app_'. $app->id);
            }

            if ($application  !== null) {
                $app = $menu->find('app_'. $application->id);
                $app->add('Users', ['route' => ['application.users','application_id'=>$application->id,'application_slug'=>$application->route_prefix]])->id('users');
                $app->add('Leaderboards', ['route' => ['application.leaderboards','application_id'=>$application->id,'application_slug'=>$application->route_prefix]])->id('lbds');
            }
        });

        if($application===null && $application_id!==null){
            if($application === null){
                $application = $accessor->getApplication($application_id);
            }

            $view->with('application',$application);
        }
    }
}