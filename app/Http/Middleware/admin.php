<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;

class admin
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

        if(!Auth::guest()){
            if(Auth::user()->id_type_user == 1){
            return $next($request);

            }
        }
            return redirect()->route('logout');
           
    }
}
