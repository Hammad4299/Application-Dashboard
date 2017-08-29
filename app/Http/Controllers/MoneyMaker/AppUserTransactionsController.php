<?php

namespace App\Http\Controllers\MoneyMaker;

use App\Classes\Helper;
use App\Models\AppUserTransaction;
use App\Models\ModelAccessor\ApplicationAccessor;
use App\Models\ModelAccessor\AppUserAccessor;
use App\Models\ModelAccessor\AppUserTransactionAccessor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppUserTransactionsController extends \App\Http\Controllers\AppUserTransactionsController
{
    public function __construct(AppUserTransactionAccessor $accessor){
        parent::__construct($accessor);
        $this->viewPrefix = "moneymaker.";
    }

    public function showPending(Request $request){
        $application_id = $request->route()->parameter('application_id');
        $params = $request->all();
        $appAccessor=new ApplicationAccessor();
        $resp = $this->appUsertranAccessor->getApplicationTransactions($appAccessor->getApplication($application_id)->data,
            $params,Helper::getWithDefault($params,'page',1),AppUserTransaction::$STATUS_PENDING);

        return view($this->viewPrefix.'applications.transactions.index', ['transactions' => $resp->data,'tab'=>'Pending','application_id'=>$application_id]);
    }

    public function showAccepted(Request $request){
        $application_id = $request->route()->parameter('application_id');
        $params = $request->all();
        $appAccessor=new ApplicationAccessor();
        $resp = $this->appUsertranAccessor->getApplicationTransactions($appAccessor->getApplication($application_id)->data,
            $params,Helper::getWithDefault($params,'page',1),AppUserTransaction::$STATUS_ACCEPTED);

        return view($this->viewPrefix.'applications.transactions.index', ['transactions' => $resp->data,'tab'=>'Accepted','application_id'=>$application_id]);
    }

    public function showRejected(Request $request){
        $application_id = $request->route()->parameter('application_id');
        $params = $request->all();
        $appAccessor=new ApplicationAccessor();
        $resp = $this->appUsertranAccessor->getApplicationTransactions($appAccessor->getApplication($application_id)->data,
            $params,Helper::getWithDefault($params,'page',1),AppUserTransaction::$STATUS_REJECTED);

        return view($this->viewPrefix.'applications.transactions.index', ['transactions' => $resp->data,'tab'=>'Rejected','application_id'=>$application_id]);
    }
}
