<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        }

        // If the application is locked, redirect to locked-form.
        if(session()->get('locked')) {
            return redirect()->action('Auth\AuthController@locked');
        }

        // If user logged in via a remember token, lock application for security purposes
        if(Auth::viaRemember()) {
            return redirect()->action('Auth\AuthController@lock');
        }

        return $next($request);
    }
}
