<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // Allow only workers (type_id 2) or admins (type_id 3)
        if (Auth::check() && (Auth::user()->type_id == 3)) {
            return $next($request);
        }

        // Redirect unauthorized users to the dashboard
        return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
    }
}
