<?php

namespace Modules\Auth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next) {
            if(Auth::check()) 
            {
                return $next($request);
            }
                    
            return response()->json(['message'=>"you are not loggedin"],400);
        }
}
