<?php

namespace App\Http\Middleware;
use Session;
use Closure;
class isActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(auth()->user()->status == 'Inactive')
        {
            auth()->logout();
            Session::flash('validate','User is inactive.');
            return redirect('/login');
        }
        return $next($request);    
    }
}
