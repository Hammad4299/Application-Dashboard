<?php

namespace App\Http\Controllers\MoneyMaker;

use App\Applications\MoneyMakerApplication;
use App\Http\Middleware\CanAccessApplicationCheck;
use App\Http\Middleware\RedirectIfNotAuthenticated;
use App\Models\AppUserTransaction;
use App\Models\ModelAccessor\MoneyMaker\AppUserTransactionAccessor;
use Illuminate\Http\Request;

class AppUserTransactionsController extends \App\Http\Controllers\AppUserTransactionsController
{
    protected $applicationConfig;
    public function __construct(AppUserTransactionAccessor $accessor){
        parent::__construct($accessor);
        $this->applicationConfig = MoneyMakerApplication::getInstance();
        $this->viewPrefix = $this->applicationConfig->getViewPrefix();
        $this->middleware(RedirectIfNotAuthenticated::class);
        $this->middleware(CanAccessApplicationCheck::class);
    }

    public function showPending(Request $request){
        $application_id = $request->route()->parameter('application_id');
        $resp = $this->appUsertranAccessor->getApplicationTransactions($application_id, AppUserTransaction::$STATUS_PENDING, [
            'paginate'=>100
        ]);
        return view($this->viewPrefix.'applications.transactions.index', ['transactions' => $resp->data,'tab'=>'Pending','application_id'=>$application_id]);
    }

    public function showAccepted(Request $request){
        $application_id = $request->route()->parameter('application_id');
        $resp = $this->appUsertranAccessor->getApplicationTransactions($application_id, AppUserTransaction::$STATUS_ACCEPTED, [
            'paginate'=>100
        ]);
        return view($this->viewPrefix.'applications.transactions.index', ['transactions' => $resp->data,'tab'=>'Accepted','application_id'=>$application_id]);
    }

    public function showRejected(Request $request){
        $application_id = $request->route()->parameter('application_id');
        $resp = $this->appUsertranAccessor->getApplicationTransactions($application_id, AppUserTransaction::$STATUS_REJECTED, [
            'paginate'=>100
        ]);
        return view($this->viewPrefix.'applications.transactions.index', ['transactions' => $resp->data,'tab'=>'Rejected','application_id'=>$application_id]);
    }

    public function updateStatus(Request $request){
        $application_id = $request->route()->parameter('application_id');
        $transaction_id = $request->route()->parameter('transaction_id');
        $status = $request->get('status');
        $resp = $this->appUsertranAccessor->updateStatus($transaction_id, $application_id,$status);
        return json_encode($resp);
    }
}
