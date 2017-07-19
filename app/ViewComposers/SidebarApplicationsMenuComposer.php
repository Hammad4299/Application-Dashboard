<?php

namespace App\ViewComposers;

use App\Classes\Helper;
use App\Models\Application;
use App\Models\ModelAccessor\ApplicationAccessor;
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
        $this->menu->make('DashboardNavbar', function ($menu) use ($view){
            $accessor = new ApplicationAccessor();
            $data = $view->getData();

            $applications = Helper::getWithDefault($data, 'applications', '');

            $application = Helper::getWithDefault($data, 'application', '');
            $menu->add('Applications', ['route' => 'application.index'])->id('apps');
            if (!isset($applications) || empty($applications)) {
                $applications = $accessor->getAllApplications();
                foreach ($applications->data as $app) {
                    $menu->find('apps')->add($app->name,
                        ['route' => ['application.show', 'application_id' => $app->id]]
                    )->id('app_'. $app->id);
                }
            }
            if (isset($application)) {
                $app = $menu->find('app_'. $application->id);
                $app->add('Users', ['route' => 'application.users'])->id('users');
                $app->add('Leaderboards', ['route' => 'application.leaderboards'])->id('lbds');
            }
        });
    }
}