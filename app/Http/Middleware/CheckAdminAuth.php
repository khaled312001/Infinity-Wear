<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if admin is authenticated using admin guard
        if (!Auth::guard('admin')->check()) {
            // Handle AJAX requests with JSON response
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'يجب تسجيل الدخول أولاً.',
                    'error' => 'unauthenticated'
                ], 401);
            }
            
            return redirect()->route('admin.login');
        }

        $admin = Auth::guard('admin')->user();
        
        // Check if admin exists
        if (!$admin) {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login')->with('error', 'حسابك غير موجود.');
        }
        
        // Check if admin is active
        if (isset($admin->is_active) && !$admin->is_active) {
            Auth::guard('admin')->logout();
            
            // Handle AJAX requests with JSON response
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'حسابك غير نشط. يرجى التواصل مع الإدارة.',
                    'error' => 'account_inactive'
                ], 403);
            }
            
            return redirect()->route('admin.login')->with('error', 'حسابك غير نشط. يرجى التواصل مع الإدارة.');
        }

        // Allow access to admin dashboard - no permission check needed
        return $next($request);
    }
}
