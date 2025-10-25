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
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next, string $permission)
    {
        // Check admin permissions
        if (Auth::guard('admin')->check()) {
            $admin = Auth::guard('admin')->user();
            if (!$this->hasAdminPermission($admin, $permission)) {
                // Handle AJAX requests with JSON response
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'ليس لديك صلاحية للوصول إلى هذه الصفحة.',
                        'error' => 'permission_denied'
                    ], 403);
                }
                
                return redirect()->route('admin.dashboard')
                    ->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة.');
            }
            return $next($request);
        }

        // Check if user is authenticated
        if (!Auth::check()) {
            // Handle AJAX requests with JSON response
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'يجب تسجيل الدخول أولاً.',
                    'error' => 'unauthenticated'
                ], 401);
            }
            
            return redirect()->route('login');
        }

        $user = Auth::user();
        $userType = $user->user_type;

        // Check if user has permission for this page
        if (!$this->hasPermission($userType, $permission)) {
            // Handle AJAX requests with JSON response
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'ليس لديك صلاحية للوصول إلى هذه الصفحة.',
                    'error' => 'permission_denied'
                ], 403);
            }
            
            // Redirect to appropriate dashboard with error message for regular requests
            $dashboardRoute = $this->getDashboardRoute($userType);
            return redirect()->route($dashboardRoute)
                ->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة.');
        }

        return $next($request);
    }

    /**
     * Check if admin has specific permission
     */
    private function hasAdminPermission($admin, string $permission): bool
    {
        try {
            // If admin has no roles/permissions defined, allow by default
            if (!$admin || !method_exists($admin, 'roles')) {
                return true;
            }

            // Check if admin has the permission through any of their roles
            foreach ($admin->roles as $role) {
                foreach ($role->permissions as $rolePermission) {
                    if ($rolePermission->name === $permission) {
                        return true;
                    }
                }
            }

            return false;
        } catch (\Exception $e) {
            // If error occurs, allow access
            return true;
        }
    }

    /**
     * Check if user type has specific permission
     */
    private function hasPermission(string $userType, string $permission): bool
    {
        try {
            // If no permissions are defined for this user type yet, allow by default
            $definedForType = DB::table('user_type_permissions')
                ->where('user_type', $userType)
                ->count();
            if ($definedForType === 0) {
                return true;
            }

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
            default => 'importers.dashboard'
        };
    }
}
