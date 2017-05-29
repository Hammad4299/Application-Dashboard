<?php

namespace App\Http\Middleware;

use App\Classes\AppResponse;
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
        }


        return $next($request);
    }
}
