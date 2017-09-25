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

    public function scopeQueryData($query, $options = [])
    {
        $d = $query;
        if(isset($options['order'])){
            foreach ($options['order'] as $order){
                $d = $d->orderBy($order[0],$order[1]);
            }
        }

        if (isset($options['limit'])) {
            $d = $query->limit($options['limit'])->get();
        } else if (isset($options['paginate'])) {
            $alias = 'page';
            if(isset($options['page_param']))
                $alias = $options['page_param'];

            $d = $query->paginate($options['paginate'],['*'],$alias);
        } else {
            $d = $query->get();
        }

        return $d;
    }
}
