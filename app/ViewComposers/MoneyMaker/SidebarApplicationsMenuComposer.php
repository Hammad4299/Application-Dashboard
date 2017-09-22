<?php

namespace App\ViewComposers\MoneyMaker;

use App\Applications\BaseApplication;
use App\Classes\Helper;
use App\Models\Application;
use App\Models\ModelAccessor\ApplicationAccessor;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Lavary\Menu\Collection;
use Lavary\Menu\Menu;

class SidebarApplicationsMenuComposer extends \App\ViewComposers\SidebarApplicationsMenuComposer {
    public function __construct(Menu $menu)
    {
        parent::__construct($menu);
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        parent::compose($view);

        $data = $view->getData();

        $application = Helper::getWithDefault($data, 'application');
        $application_id = Helper::getWithDefault($data, 'application_id');
        $accessor = new ApplicationAccessor();
        if($application===null && $application_id!==null){
            if($application === null){
                $application = $accessor->getApplication($application_id)->data;
            }

            $view->with('application',$application);
        }

        $applicationConf = BaseApplication::getApplication($application->mapped_name);
        $view->with('applicationConfig', $applicationConf);
        $menu = $this->menu->get('DashboardNavbar');
        $menu->find('apps')->link->href('#');
            if ($application  !== null) {
                $app = $menu->find('app_'. $application->id);
                $app->add('Users',
                        ['route' => [
                            $applicationConf->getRouteNamePrefix().'application.users',
                            'application_id' => $application->id
                        ]
                    ])->id('users');

                $app->add('Transactions',
                    ['route' => [
                        $applicationConf->getRouteNamePrefix().'application.transactions.pending',
                        'application_id' => $application->id
                    ]
                    ])->id('transactions');
            }
    }
}