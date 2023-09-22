<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckValidUser
{
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check() && (Auth::user()->active != 'S')){
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('error', 'Acceso no autorizado: Tu cuenta ha sido suspendida.');

        }
        return $next($request);
    }
}
