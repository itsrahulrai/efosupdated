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

        // wrong role (example admin trying student route)
        if (Auth::user()->role !== $role) {

            // if admin logged in, redirect admin dashboard
            if (Auth::user()->role == 'admin') {

                return redirect()->route('admin.dashboard')
                    ->with('error', 'Please login as Student to enroll free course.');
            }

            // default redirect back
            return redirect()->back()
                ->with('error', 'Unauthorized access.');
        }

        return $next($request);
    }
}