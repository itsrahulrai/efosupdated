<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */

    // public function store(LoginRequest $request): RedirectResponse
    // {
    //     $request->authenticate();
    //     $request->session()->regenerate();

    //     $user = Auth::user();

    //     // ---------- ADMIN ----------
    //     if ($user->role === 'admin') {
    //         return redirect('/admin/dashboard');
    //     }

    //     // ---------- FRANCHISE ----------
    //     if ($user->role === 'franchise') {
    //         if (!$user->franchiseProfile || $user->franchiseProfile->status !== 'approved') {
    //             Auth::logout();
    //             return redirect('/login')->withErrors([
    //                 'error' => 'Your franchise account is under review.'
    //             ]);
    //         }
    //         return redirect('/franchise/dashboard');
    //     }

    //     // ---------- STUDENT ----------
    //     if ($user->role === 'student') {

    //         // ✅ THIS IS THE MAGIC LINE
    //         // return redirect()->intended(route('student.dashboard'));
    //         return redirect()->route('student.dashboard');
    //     }

    //     Auth::logout();
    //     return redirect('/login')->withErrors(['error' => 'Invalid role']);
    // }

    public function store(LoginRequest $request): RedirectResponse
    {
        // dd($request->all());

        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        // ---------- ADMIN ----------
        if ($user->role === 'admin')
        {
            return redirect('/admin/dashboard');
        }

        // ---------- FRANCHISE ----------
        if ($user->role === 'franchise')
        {
            if (!$user->franchiseProfile || $user->franchiseProfile->status !== 'approved')
            {
                Auth::logout();
                return redirect('/login')->withErrors([
                    'error' => 'Your franchise account is under review.',
                ]);
            }
            return redirect('/franchise/dashboard');
        }

        // ---------- STUDENT ----------
        if ($user->role === 'student')
        {
            return redirect()->route('student.dashboard');
        }

        // ---------- MENTOR ----------
        if ($user->role === 'mentor')
        {
            if (!$user->mentorProfile || $user->mentorProfile->status !== 'approved')
            {
                Auth::logout();
                return redirect('/login')->withErrors([
                    'error' => 'Your mentor account is under review.',
                ]);
            }
            return redirect()->route('mentor.dashboard');
        }

        Auth::logout();
        return redirect('/login')->withErrors([
            'error' => 'Invalid role',
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
