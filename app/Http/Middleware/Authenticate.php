<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson())
        {
            return null;
        }

        // If trying to access student area
        if (
            $request->is('student/*') ||
            $request->is('course/*') ||
            $request->is('quiz/*') ||
            $request->is('certificates/*')
        )
        {
            return route('student.login');
        }

        // Default → Admin login
        return route('login');
    }
}
