<?php
/**
 * Created by PhpStorm.
 * User: talha
 * Date: 12/17/2016
 * Time: 4:07 PM
 */

namespace App\Models;

trait ModelTrait
{
    public function isRelationLoaded($name){
        return isset($this->relations[$name]);
    }
}
