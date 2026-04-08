<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {

        // not logged in
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Please login first.');
        }

        // wrong role
        if (Auth::user()->role !== $role) {

            // admin logged in but trying student page
            if (Auth::user()->role == 'admin') {

                return redirect()->route('admin.dashboard')
                    ->with('error', 'Access denied for this section.');
            }

            // mentor logged in
            if (Auth::user()->role == 'mentor') {

                return redirect()->route('mentor.dashboard')
                    ->with('error', 'Access denied for this section.');
            }

            // franchise logged in
            if (Auth::user()->role == 'franchise') {

                return redirect()->route('franchise.dashboard')
                    ->with('error', 'Access denied for this section.');
            }

            // default
            return redirect('/')
                ->with('error', 'Unauthorized access.');
        }

        return $next($request);
    }
}