<?php

namespace App\Http\Middleware;

use App\Classes\AppResponse;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UnpermittedFields
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
        if($request->has('fbid')){
            $resp = new AppResponse(true);
            $resp->addError('fbid','You cannot set this field');
            return response()->json($resp,403);
        }

        return $next($request);
    }
}
