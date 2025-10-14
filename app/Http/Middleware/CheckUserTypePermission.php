<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckUserTypePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  $permission
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $permission)
    {
        // Skip permission check for admin users
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }

        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $userType = $user->user_type;

        // Check if user has permission for this page
        if (!$this->hasPermission($userType, $permission)) {
            // Redirect to appropriate dashboard with error message
            $dashboardRoute = $this->getDashboardRoute($userType);
            return redirect()->route($dashboardRoute)
                ->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة.');
        }

        return $next($request);
    }

    /**
     * Check if user type has specific permission
     */
    private function hasPermission(string $userType, string $permission): bool
    {
        try {
            $hasPermission = DB::table('user_type_permissions')
                ->where('user_type', $userType)
                ->where('permission', $permission)
                ->exists();

            return $hasPermission;
        } catch (\Exception $e) {
            // If table doesn't exist or error occurs, allow access
            return true;
        }
    }

    /**
     * Get dashboard route for user type
     */
    private function getDashboardRoute(string $userType): string
    {
        return match($userType) {
            'admin' => 'admin.dashboard',
            'importer' => 'importers.dashboard',
            'sales' => 'sales.dashboard',
            'marketing' => 'marketing.dashboard',
            default => 'customer.dashboard'
        };
    }
}
