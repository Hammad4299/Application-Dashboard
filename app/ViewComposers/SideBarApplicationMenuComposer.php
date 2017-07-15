<?php

namespace App\ViewComposers;

use App\Models\Application;
use Illuminate\View\View;
use Lavary\Menu\Collection;
use Lavary\Menu\Menu;

class SidebarApplicationMenuComposer {
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
        $application = $data['application'];
        $this->menu->make('DashboardNavbar', function ($menu){
            $menu->add('Applications');
        });

        $menuItems = $this->menu->get('DashboardNavbar');
        foreach ($applications as $app) {
            $menuItems->applications->add($app->name);
        }

    }
}