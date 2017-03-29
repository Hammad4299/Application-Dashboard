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
                $validator = Validator::make([],[]);
                $validator->errors()->add('api_token','Invalid or missing token');
                $resp = new AppResponse(false,null,$validator);
                return response()->json($resp,401);
            }else{
            }
        }


        return $next($request);
    }
}
