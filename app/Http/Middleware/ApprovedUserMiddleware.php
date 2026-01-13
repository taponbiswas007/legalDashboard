<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApprovedUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function handle(Request $request, Closure $next)
    {
        // Allow access to all Breeze auth and public routes
        if (
            $request->routeIs('login') ||
            $request->routeIs('logout') ||
            $request->routeIs('register') ||
            $request->routeIs('password.*') ||
            $request->routeIs('verification.*') ||
            $request->routeIs('two-factor.*') ||
            $request->routeIs('user-profile-information.update') ||
            $request->routeIs('user-password.update') ||
            $request->routeIs('user-password.confirm') ||
            $request->routeIs('user-password.request') ||
            $request->routeIs('user-password.email') ||
            $request->routeIs('user-password.reset') ||
            $request->routeIs('user-password.store')
        ) {
            return $next($request);
        }

        if (Auth::check() && !Auth::user()->approved) {
            $guard = Auth::getDefaultDriver();
            // Only call logout if the guard is session-based
            if (in_array($guard, ['web', 'session'])) {
                Auth::logout();
            } else {
                $user = Auth::user();
                if (method_exists($user, 'tokens')) {
                    $user->tokens()->delete();
                }
            }
            // Prevent redirect loop: only redirect if not already on public/auth route
            if (!(
                $request->routeIs('login') ||
                $request->routeIs('logout') ||
                $request->routeIs('register') ||
                $request->routeIs('password.*') ||
                $request->routeIs('verification.*') ||
                $request->routeIs('two-factor.*')
            )) {
                return redirect()->route('login')->withErrors(['Your account is pending approval by the super admin.']);
            }
        }
        return $next($request);
    }
}
