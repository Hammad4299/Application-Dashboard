<?php

namespace App\Http\Controllers\Api;

use App\Classes\AuthHelper;
use App\Http\Controllers\Controller;
use App\Models\ModelAccessor\QueuedRequestAccessor;
use Illuminate\Http\Request;

class QueueRequestController extends Controller
{
    protected $accessor;
    public function __construct(QueuedRequestAccessor $accessor){
        $this->accessor = $accessor;
        $this->middleware('authcheck:appapi');
    }

    /**
     * @api {POST} application/request/queue Create Queued Request
     * @apiGroup Queued Request
     * @apiVersion 0.1.0
     * @apiParam {String} url Relative url without leading slash e.g application/request/queue
     * @apiParam {String=GET,get,post,POST} method
     * @apiParam {String} [headers] JSON of headers key value pair
     * @apiParam {String} [query] JSON of query string key value pair
     * @apiParam {String} [data] JSON of request data key value pair
     * @apiParam {Integer=1,2} [data_type] Type of data specified. 1=form. 2=multipart
     * @apiSuccess (Success) {Response(QueuedRequest)} Body Json of <b>Response</b> Object
     * @apiUse authApp
     * @apiUse queuedSupport
     * @apiUse errorUnauthorized
     * @param Request $request
     * @return $mixed
     **/
    public function create(Request $request){
        $countries = $this->accessor->create($request->all(),AuthHelper::AppAuth()->user()->id);
        $this->accessor->onComplete($countries,$request->all(),AuthHelper::AppAuth()->user()->id);
        return response()->json($countries);
    }

    /**
     * @api {GET} application/request/queue/:id Get Queued Request
     * @apiGroup Queued Request
     * @apiVersion 0.1.0
     * @apiSuccess (Success) {Response(QueuedRequest)} Body Json of <b>Response</b> Object
     * @apiUse authApp
     * @apiUse errorUnauthorized
     * @param Request $request
     * @return $mixed
     **/
    public function get(Request $request,$id){
        $countries = $this->accessor->getRequest($id,AuthHelper::AppAuth()->user()->id);
        return response()->json($countries);
    }

    /**
     * @api {POST} application/request/queue/:id/delete Delete Queued Request
     * @apiGroup Queued Request
     * @apiVersion 0.1.0
     * @apiUse queuedSupport
     * @apiSuccess (Success) {Response(Object)} Body Json of <b>Response</b> Object. It will be null.
     * @apiUse authApp
     * @apiUse errorUnauthorized
     * @param Request $request
     * @return $mixed
     **/
    public function delete(Request $request,$id){
        $countries = $this->accessor->deleteRequest($id,AuthHelper::AppAuth()->user()->id);
        $this->accessor->onComplete($countries,$request->all(),AuthHelper::AppAuth()->user()->id);
        return response()->json($countries);
    }
}