<?php

namespace App\Models\ModelAccessor;


use App\Classes\AppResponse;
use App\Classes\Helper;
use App\Models\BusinessLogic\QueuedRequestExecutor;


class BaseAccessor
{
    public function createNewToken(){
        return Helper::generateRandomString(128);
    }

    public function onComplete(AppResponse $response, $data, $application_id = null){
        if(!isset($data['prevent_queue']) && isset($data['queued_request_id'])){
            $accessor = new QueuedRequestAccessor();
            $ids = json_decode($data['queued_request_id'],true);
            $executor = new QueuedRequestExecutor();
            if(count($ids)>0){
                $resp = $accessor->getRequests($ids,$application_id);
                $req = $resp->data;
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