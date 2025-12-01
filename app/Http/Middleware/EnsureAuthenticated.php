<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureAuthenticated
{
    /**
     * Handle an incoming request.
     * Redirect to login if the user is not authenticated.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['message' => 'Non authentifié.'], 401);
            }

            return redirect()->route('login');
        }

        return $next($request);
    }
}
