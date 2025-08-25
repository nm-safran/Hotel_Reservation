<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClerkMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && (Auth::user()->role === 'clerk' || Auth::user()->role === 'admin')) {
            return $next($request);
        }

        return redirect('/')->with('error', 'Access denied. Reservation clerk privileges required.');
    }
}
