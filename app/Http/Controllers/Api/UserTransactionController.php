<?php
namespace App\Http\Controllers\Api;
use App\Classes\AuthHelper;
use App\Http\Controllers\Controller;
use App\Models\ModelAccessor\AppUserAccessor;
use App\Models\ModelAccessor\AppUserTransactionAccessor;
use Illuminate\Http\Request;

/**
 * Created by PhpStorm.
 * User: talha
 * Date: 3/29/2017
 * Time: 7:21 PM
 */
class UserTransactionController extends Controller
{
    protected $accessor;
    public function __construct()
    {
        $this->accessor = new AppUserTransactionAccessor();
        $this->middleware('authcheck:appapi',['only'=>['updateStatus','getApplicatonTransactions']]);
        $this->middleware('authcheck:app-user-api',['except'=>['updateStatus','getApplicatonTransactions']]);
    }

    /**
     * @api {POST} application/transactions/update-status Update Transaction Status
     * @apiGroup UserTransaction
     * @apiVersion 0.1.0
     * @apiUse queuedSupport
     * @apiParam (form) {Integer} id Transaction ID to update
     * @apiParam (form) {Integer=1,2,3} status Transaction Status to set
     * @apiSuccess (Success) {Response(Object)} Body Json of <b>Response</b> Object
     * @apiUse authApp
     * @apiUse errorUnauthorized
     * @param Request $request
     * @return $mixed
     **/
    public function updateStatus(Request $request){
        $resp = $this->accessor->updateStatus($request->get('id'),AuthHelper::AppAuth()->user()->id,$request->get('status'));
        $this->accessor->onComplete($resp,$request->all(),AuthHelper::AppAuth()->user()->id);
        return response()->json($resp);
    }

    /**
     * @api {GET} application/transactions Get Application Transactions
     * @apiGroup UserTransaction
     * @apiVersion 0.1.0
     * @apiSuccess (Success) {Response(UserTransaction[])} Body Json of <b>Response</b> Object
     * @apiUse authApp
     * @apiUse errorUnauthorized
     * @param Request $request
     * @return $mixed
     **/
    public function getApplicatonTransactions(Request $request){
        $resp = $this->accessor->getApplicationTransactions(AuthHelper::AppAuth()->user()->id);
        return response()->json($resp);
    }

    /**
     * @api {GET} application/user/transactions Get User Transactions
     * @apiGroup UserTransaction
     * @apiVersion 0.1.0
     * @apiSuccess (Success) {Response(UserTransaction[])} Body Json of <b>Response</b> Object
     * @apiUse authUser
     * @apiUse errorUnauthorized
     * @param Request $request
     * @return $mixed
     **/
    public function getUserTransactions(Request $request){
        $resp = $this->accessor->getUserTransactions(AuthHelper::AppUserAuth()->user());
        return response()->json($resp);
    }

    /**
     * @api {POST} application/user/transactions Create Transaction
     * @apiGroup UserTransaction
     * @apiVersion 0.2.0
     * @apiUse queuedSupport
     * @apiParam (form) {Integer} amount Amount of Transaction
     * @apiParam (form) {Integer} [leaderboard_id] <b>This is atomic</b>. Leaderboard score to update.
     * @apiParam (form) {Integer} [score] <b>This is atomic</b>. New score value.
     * @apiSuccess (Success) {Response(UserTransaction)} Body Json of <b>Response</b> Object
     * @apiUse authUser
     * @apiUse errorUnauthorized
     * @param Request $request
     * @return $mixed
     **/
    public function postTransaction(Request $request){
        $resp = $this->accessor->create($request->all(),AuthHelper::AppUserAuth()->user());
        $this->accessor->onComplete($resp,$request->all(),AuthHelper::AppUserAuth()->user()->application_id);
        return response()->json($resp);
    }
}