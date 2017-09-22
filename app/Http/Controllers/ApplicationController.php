<?php

namespace App\Http\Controllers;

use App\Http\Middleware\RedirectIfNotAuthenticated;
use App\Models\ModelAccessor\ApplicationAccessor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    protected $applicationAccessor;
    protected $viewPrefix;
    public function __construct(ApplicationAccessor $accessor){
        $this->applicationAccessor = $accessor;
        $this->viewPrefix = "";
        $this->middleware(RedirectIfNotAuthenticated::class);
    }

    public function index () {
        $resp = $this->applicationAccessor->getUserApplications(Auth::user()->id);
        $resp->isApi = false;

        return view($this->viewPrefix.'applications.index',
            [
                'applications' => $resp->data
            ]);
    }
}
