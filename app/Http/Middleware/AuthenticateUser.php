<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthenticateUser
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('firebase_token')) {
            Log::info('Unauthorized access attempt.');
            return redirect('/login')->withErrors(['error' => 'Please log in to access this page.']);
        }

        // Check if the user has a department and redirect accordingly
        $department = session('department');
        if ($department) {
            if (!$request->is('department/*')) {
                return redirect('/department/dashboard');
            }
        } else {
            if (!$request->is('Dashboard')) {
                return redirect('/Dashboard');
            }
        }

        return $next($request);
    }
}
