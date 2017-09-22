<?php

namespace App\Applications;
use App\Classes\Helper;
use App\Interfaces\IRouteNamePrefix;

/**
 * Created by PhpStorm.
 * User: talha
 * Date: 9/22/2017
 * Time: 11:09 PM
 */
abstract class BaseApplication implements IRouteNamePrefix
{
    protected $config;
    const MAPPED_NAME = 'mappedName';
    const ROUTE_PREFIX = 'routePrefix';
    const ROUTE_NAME_PREFIX = 'routeNamePrefix';
    const VIEW_PREFIX = 'viewPrefix';
    const CONTROLLER_NAMESPACE = 'controllerNamespace';

    protected function __construct()
    {
        $this->config = [];
        $this->initConfig();
    }

    public static function getApplicationMap(){
        $moneyMaker = MoneyMakerApplication::getInstance();
        return [
            $moneyMaker->getMappedName() => $moneyMaker
        ];
    }

    /**
     * @param $appName
     * @return BaseApplication
     */
    public static function getApplication($appName){
        return Helper::getWithDefault(self::getApplicationMap(),$appName);
    }

    public function getControllerNamespace(){
        return Helper::getWithDefault($this->config,self::CONTROLLER_NAMESPACE);
    }

    public  function getViewPrefix(){
        return Helper::getWithDefault($this->config,self::VIEW_PREFIX);
    }

    public function getRoutePrefix(){
        return Helper::getWithDefault($this->config,self::ROUTE_PREFIX);
    }

    protected function getMappedName(){
        return Helper::getWithDefault($this->config,self::MAPPED_NAME);
    }

    public abstract function initConfig();
    public abstract function registerRoutes();
    public abstract function registerViewComposers();

    function getRouteNamePrefix()
    {
        return Helper::getWithDefault($this->config,self::ROUTE_NAME_PREFIX);
    }
}