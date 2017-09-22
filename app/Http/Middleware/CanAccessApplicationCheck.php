<?php

namespace App\Http\Middleware;

use App\Models\ModelAccessor\ApplicationAccessor;
use Closure;
use Illuminate\Support\Facades\Auth;

class CanAccessApplicationCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $application_id = $request->route()->parameter('application_id');
        if(!empty($application_id) && Auth::check()){
            $accessor = new ApplicationAccessor();
            $app = $accessor->getApplicationSecure($application_id,Auth::user()->id);
            if($app == null){
                return response('Not allowed',403);
            }
        }


        return $next($request);
    }
}
