<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Admin
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
        $allowedRoles = [
          env('ADMIN_ROLE'),
          env('SECRETAIRE_ROLE'),
        ];

        if ( in_array(auth()->user()->role , $allowedRoles) ){
            return $next($request);
        }
        Auth::logout();
        return redirect()->route('login')->with('accessError', 'Accès non autorisé');

    }
}
