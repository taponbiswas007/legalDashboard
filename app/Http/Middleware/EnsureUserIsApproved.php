<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
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
            Log::info('EnsureUserIsApproved: Allowed public/auth route', [
                'route' => $request->route() ? $request->route()->getName() : null,
                'url' => $request->fullUrl(),
                'user_id' => Auth::id(),
            ]);
            return $next($request);
        }

        if (Auth::check() && !Auth::user()->approved) {
            $guard = Auth::getDefaultDriver();
            if (in_array($guard, ['web', 'session'])) {
                Auth::logout();
            } else {
                $user = Auth::user();
                /**
                 * Only delete tokens if the user model supports it (e.g., uses HasApiTokens).
                 * method_exists is sufficient for Eloquent relationships.
                 */
                if (method_exists($user, 'tokens')) {
                    Log::info('EnsureUserIsApproved: Redirecting unapproved user to login', [
                        'user_id' => Auth::id(),
                        'route' => $request->route() ? $request->route()->getName() : null,
                        'url' => $request->fullUrl(),
                    ]);
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
                Log::warning('EnsureUserIsApproved: Unapproved user detected', [
                    'user_id' => Auth::id(),
                    'route' => $request->route() ? $request->route()->getName() : null,
                    'url' => $request->fullUrl(),
                    'guard' => Auth::getDefaultDriver(),
                ]);
                return redirect()->route('login')->withErrors(['email' => 'Your account is not approved yet.']);
            }
        }

        return $next($request);
    }
}
