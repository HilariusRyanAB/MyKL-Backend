<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class IsEmployee
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user() &&  Auth::user()->user_role == 'Employee') {
            return $next($request);
        }

        return response([
            'message' => 'Restricted'
        ], 200);
    }
}