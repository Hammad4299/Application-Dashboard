<?php

namespace App\Http\Middleware;

use App\Classes\AppResponse;
use App\Http\Controllers\Api\AppUserController;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CheckAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null, $api = true)
    {
        if (!Auth::guard($guard)->check()) {
            if($api){
                $resp = new AppResponse(true);
                $resp->addError('api_token','Invalid or missing token');
                return response()->json($resp,401);
            }else{
            }
        }else{
            $resp = new AppResponse(true);
            $resp->data = Auth::guard($guard)->user();
            $resp = AppUserController::processAppResponseForLogin($resp);
            if(!$resp->getStatus()){
                return response()->json($resp,403);
            }
        }

        return $next($request);
    }
}
