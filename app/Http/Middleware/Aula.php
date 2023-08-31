<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class Aula
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!Auth::check())
        {
            return redirect()->route('login');
        }
    
        $role = Auth::user()->role;

        if($role == 'instructor' || $role == 'participants')
        {
            return $next($request);
        }else{
            abort(403, 'Acceso denegado');
        }
    }
}
