<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check() || Auth::user()->role !== $role) {
            // Redirect based on current role if they are logged in but unauthorized
            if (Auth::check()) {
                session()->flash('error', 'Unauthorized access.');
                if (Auth::user()->role === 'admin') return redirect('/admin/dashboard');
                if (Auth::user()->role === 'staff') return redirect('/staff/dashboard');
                return redirect('/home');
            }
            return redirect('/login')->with('error', 'Please login first.');
        }

        return $next($request);
    }
}
