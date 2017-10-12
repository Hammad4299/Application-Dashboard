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
    public function __construct(AppUserTransactionAccessor $appUserTransactionAccessor)
    {
        $this->accessor = $appUserTransactionAccessor;
        $this->middleware('authcheck:appapi',['only'=>['updateStatus','getApplicatonTransactions']]);
        $this->middleware('authcheck:app-user-api',['except'=>['updateStatus','getApplicatonTransactions']]);
    }

    /**
     * @api {POST} application/transactions/update-status Update Transaction Status
     * @apiGroup UserTransaction (General)
     * @apiVersion 0.1.0
     * @apiUse UserTransactionUpdateCommon
     * @apiUse authApp
     * @apiUse queuedSupport
     * @apiUse errorUnauthorized
     **/
    public function updateStatus(Request $request){
        $resp = $this->accessor->updateStatus($request->get('id'),AuthHelper::AppAuth()->user()->id,$request->get('status'));
        $this->accessor->onComplete($resp,$request->all(),AuthHelper::AppAuth()->user()->id);
        return response()->json($resp);
    }

    /**
     * @apiDescription <b>Deprecated</b>
     * @api {GET} application/transactions Get Application Transactions
     * @apiGroup UserTransaction (General)
     * @apiVersion 0.1.0
     * @apiUse UserTransactionAppGetCommon
     * @apiUse authApp
     * @apiUse errorUnauthorized
     **/
//    public function getApplicatonTransactions(Request $request){
//        $resp = $this->accessor->getApplicationTransactions(AuthHelper::AppAuth()->user()->id);
//        return response()->json($resp);
//    }

    /**
     * @api {GET} application/user/transactions Get User Transactions
     * @apiGroup UserTransaction (General)
     * @apiVersion 0.1.0
     * @apiUse UserTransactionUserGetCommon
     * @apiUse authUser
     * @apiUse errorUnauthorized
     **/
    public function getUserTransactions(Request $request){
        $resp = $this->accessor->getUserTransactions(AuthHelper::AppUserAuth()->user());
        return response()->json($resp);
    }

    /**
     * @api {POST} application/user/transactions Create Transaction
     * @apiGroup UserTransaction (General)
     * @apiVersion 0.2.0
     * @apiUse UserTransactionCreateCommon
     * @apiUse authUser
     * @apiUse errorUnauthorized
     * @apiUse queuedSupport
     **/
    public function postTransaction(Request $request){
        $resp = $this->accessor->create($request->all(),AuthHelper::AppUserAuth()->user());
        $this->accessor->onComplete($resp,$request->all(),AuthHelper::AppUserAuth()->user()->application_id);
        return response()->json($resp);
    }
}