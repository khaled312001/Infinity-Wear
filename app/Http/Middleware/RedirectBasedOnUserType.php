<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectBasedOnUserType
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
        if (Auth::check()) {
            $user = Auth::user();
            
            // Redirect to appropriate dashboard based on user type
            if ($request->is('/') || $request->is('home')) {
                switch ($user->user_type) {
                    case 'admin':
                        return redirect()->route('admin.dashboard');
                    case 'importer':
                        return redirect()->route('importers.dashboard');
                    case 'sales':
                        return redirect()->route('sales.dashboard');
                    case 'marketing':
                        return redirect()->route('marketing.dashboard');
                }
            }
        }

        return $next($request);
    }
}