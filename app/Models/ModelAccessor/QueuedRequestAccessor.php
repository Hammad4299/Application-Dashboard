<?php

namespace App\Models\ModelAccessor;

use App\Classes\AppResponse;
use App\Classes\Helper;
use App\Models\QueuedRequest;

class QueuedRequestAccessor extends BaseAccessor
{
    public function create($data, $application_id){
        $response = new AppResponse(true);
        $req = new QueuedRequest();
        $req->application_id = $application_id;
        $req->response = null;
        $req->method = Helper::getWithDefault($data,'method');
        $req->url = Helper::getWithDefault($data,'url');
        $req->headers = Helper::getWithDefault($data,'headers');
        $req->data = Helper::getWithDefault($data,'data');
        $req->query = Helper::getWithDefault($data,'query');
        $req->data_type = Helper::getWithDefault($data,'data_type');
        $req->save();
        $response->data = $req;
        return $response;
    }

    public function getRequest($id,$application_id){
        $response = new AppResponse(true);
        $req = QueuedRequest::where('id',$id)
                ->where('application_id',$application_id)
                ->first();

        $response->data = $req;
        return $response;
    }

    public function updateResponse($id, $resp){
        $response = new AppResponse(true);
        QueuedRequest::where('id',$id)
            ->update([
                'response'=>$resp
            ]);
        return $response;
    }

    public function getRequests($id,$application_id){
        $response = new AppResponse(true);

        $req = QueuedRequest::whereIn('id',$id)
            ->where('application_id',$application_id)
            ->get();

        $response->data = $req;
        return $response;
    }

    public function deleteRequest($id,$application_id){
        $response = new AppResponse(true);
        QueuedRequest::where('id',$id)
            ->where('application_id',$application_id)
            ->delete();

        $response->data = null;
        return $response;
    }
}