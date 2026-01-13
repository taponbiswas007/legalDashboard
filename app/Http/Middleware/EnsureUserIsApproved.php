<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsApproved
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && !Auth::user()->approved) {
            Auth::logout();
            return redirect()->route('login')->withErrors(['email' => 'Your account is not approved yet.']);
        }
        return $next($request);
    }
}
