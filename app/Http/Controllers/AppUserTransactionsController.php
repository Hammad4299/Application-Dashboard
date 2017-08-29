<?php

namespace App\Http\Controllers;

use App\Http\Middleware\RedirectIfNotAuthenticated;
use App\Models\ModelAccessor\AppUserTransactionAccessor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppUserTransactionsController extends Controller
{
    protected $appUsertranAccessor;
    protected $viewPrefix;
    public function __construct(AppUserTransactionAccessor $accessor){
        $this->appUsertranAccessor = $accessor;
        $this->viewPrefix = "";
        $this->middleware(RedirectIfNotAuthenticated::class);
    }
}
