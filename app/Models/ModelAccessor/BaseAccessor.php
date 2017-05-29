<?php

namespace App\Models\ModelAccessor;


use App\Classes\AppResponse;
use App\Models\InstagramApi\QueuedRequestExecutor;

class BaseAccessor
{
    public function createNewToken(){
        return self::generateRandomString(128);
    }

    public static function getWithDefault($arrOrObject, $key ,$default = null){
        if(isset($arrOrObject[$key])){
            return $arrOrObject[$key];
        }

        return $default;
    }

    public static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function onComplete(AppResponse $response, $data, $application_id = null){
        if(!isset($data['prevent_queue']) && isset($data['queued_request_id'])){
            $accessor = new QueuedRequestAccessor();
            $ids = json_decode($data['queued_request_id'],true);
            $executor = new QueuedRequestExecutor();
            if(count($ids)>0){
                $req = $accessor->getRequests($ids,$application_id);
                $count = 0;
                foreach ($req as $r){
                    $count++;
                    $response = $executor->executeRequest($r);
                    $accessor->updateResponse($r->id,$response);

                    if($count>=5)
                        break;
                }
            }
        }
    }
}