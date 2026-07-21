<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Agar user login hi nahi hai, to login page pe bhej do
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to continue.');
        }

        // Agar login hai lekin admin nahi, to home pe bhej do (crash na ho)
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'You are not authorized to access the admin panel.');
        }

        return $next($request);
    }
}