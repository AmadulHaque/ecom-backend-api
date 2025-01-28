<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionCheck
{
    public function handle(Request $request, Closure $next, $permissions)
    {
        // Check if the user is authenticated
        if (! Auth::check()) {
            return redirect()->route('login')->with('error', 'You need to log in first.');
        }

        if (auth()->user() && Auth::user()->role->value == 5) {
            return $next($request);
        } else {
            if (auth()->user() && auth()->user()->hasPermissionTo($permissions)) {
                return $next($request);
            }
        }

        return redirect()->back()->with('error', 'You do not have permission to access this resource.');
    }
}
