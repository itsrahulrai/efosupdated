<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
 
    
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            return match ($user->role) {
                'admin'     => redirect('/admin/dashboard'),
                'franchise' => redirect('/franchise/dashboard'),
                'student'   => redirect()->route('student.dashboard'),
                default     => redirect('/'),
            };
        }

        return $next($request);
    }
}
