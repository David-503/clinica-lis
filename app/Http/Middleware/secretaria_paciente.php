<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;

class secretaria_paciente
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
            if((Auth::user()->id_type_user == 5) || (Auth::user()->id_type_user == 4)){
            return $next($request);

            }
        }
            return redirect()->route('logout');
    }
}
