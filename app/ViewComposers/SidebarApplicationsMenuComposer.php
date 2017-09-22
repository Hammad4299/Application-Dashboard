<?php

namespace App\ViewComposers;

use App\Applications\BaseApplication;
use App\Classes\Helper;

use App\Models\ModelAccessor\ApplicationAccessor;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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
        $accessor = new ApplicationAccessor();

        $this->menu->make('DashboardNavbar', function ($menu) use ($view,$data,$applications,$accessor){
            $menu->add('Applications', ['route' => 'application.index'])->id('apps');
            if($applications===null){
                $applications = $accessor->getUserApplications(Auth::user()->id)->data;
            }

            foreach ($applications as $app) {
                $applicationConf = BaseApplication::getApplication($app->mapped_name);
                $menu->find('apps')
                    ->add($app->name,
                        ['route' => [
                            $applicationConf->getRouteNamePrefix().'application.show',
                            'application_id' => $app->id
                        ]
                    ])
                    ->id('app_'. $app->id);
            }
        });
    }
}