<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\SettingsHelper;

class MaintenanceMode
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
        // Check if maintenance mode is enabled
        if (SettingsHelper::isMaintenanceMode()) {
            // Allow admin users to access the site during maintenance
            if ($request->user() && $request->user()->hasRole('admin')) {
                return $next($request);
            }

            // Show maintenance page for other users
            return response()->view('maintenance', [], 503);
        }

        return $next($request);
    }
}
