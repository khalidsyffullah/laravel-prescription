<?php


// app/Http/Middleware/UserRedirection.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserRedirection
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
        // if (Auth::check() && Auth::user()->user_type_id == 2) {
        //     // Check if the user is already on the dashboard route
        //     if (!$request->routeIs('doctor.dashboard')) {
        //         return redirect()->route('doctor.dashboard');
        //     }
        // }

        if (Auth::check()) {
            if (Auth::user()->user_type_id == 2) {
                // If the user is trying to access login/register pages, redirect to dashboard
                if ($request->routeIs('login') || $request->routeIs('register.form')) {
                    return redirect()->route('doctor.dashboard');
                }
            }
        }

        return $next($request);
    }
}
