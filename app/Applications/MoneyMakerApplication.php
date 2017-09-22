<?php
namespace App\Applications;
use App\ViewComposers\MoneyMaker\SidebarApplicationsMenuComposer;
use Illuminate\Support\Facades\Route;

/**
 * Created by PhpStorm.
 * User: talha
 * Date: 9/22/2017
 * Time: 11:09 PM
 */
class MoneyMakerApplication extends BaseApplication
{
    private static $instance;
    public static function getInstance(){
        if(self::$instance == null){
            self::$instance = new MoneyMakerApplication();
        }

        return self::$instance;
    }

    public function registerRoutes()
    {
        Route::prefix($this->getRoutePrefix())
            ->middleware('web')
            ->namespace($this->getControllerNamespace())
            ->group(base_path('routes/moneymaker.php'));
    }

    public function registerViewComposers()
    {
        view()->composer(
            [
                'moneymaker.applications.show',
                'moneymaker.applications.edit',
                'moneymaker.applications.users.index',
                'moneymaker.applications.transactions.index',
            ],SidebarApplicationsMenuComposer::class
        );
    }

    public function initConfig()
    {
        $this->config = config('moneymaker.backend_config');
    }
}