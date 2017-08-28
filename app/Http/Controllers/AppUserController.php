<?php

namespace App\Http\Controllers;

use App\Http\Middleware\RedirectIfNotAuthenticated;
use App\Models\ModelAccessor\AppUserAccessor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppUserController extends Controller
{
    protected $appUserAccessor;
    protected $viewPrefix;
    public function __construct(AppUserAccessor $accessor){
        $this->appUserAccessor = $accessor;
        $this->viewPrefix = "";
        $this->middleware(RedirectIfNotAuthenticated::class);
    }
}
