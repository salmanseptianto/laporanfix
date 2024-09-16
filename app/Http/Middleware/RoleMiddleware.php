<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!auth()->check()) {
            return redirect('/login'); // Jika user belum login, redirect ke halaman login
        }

        $userRole = auth()->user()->role;

        if ($userRole !== $role) {
            if ($userRole === 'admin') {
                return redirect('/admin');
            } elseif ($userRole === 'mm') {
                return redirect('/manager-marketing');
            } elseif ($userRole === 'marketing') {
                return redirect('/marketing'); 
            }

            return redirect('/');
        }

        return $next($request);
    }
}

