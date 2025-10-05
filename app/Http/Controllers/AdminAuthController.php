<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\Admin;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        // Debug: Log all request data
        Log::info('Admin login request data', $request->all());
        
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Admin validation failed', $e->errors());
            throw $e;
        }

        // Debug logging
        Log::info('Admin login attempt', [
            'email' => $credentials['email']
        ]);

        // Admin login
        $admin = Admin::where('email', $credentials['email'])
            ->where('is_active', 1)
            ->first();

        // Debug logging
        Log::info('Admin login attempt', [
            'email' => $credentials['email'],
            'admin_found' => $admin ? 'Yes' : 'No',
            'admin_active' => $admin ? $admin->is_active : 'N/A',
            'password_check' => $admin ? Hash::check($credentials['password'], $admin->password) : 'N/A'
        ]);

        if ($admin && Hash::check($credentials['password'], $admin->password)) {
            // Admin login successful
            Log::info('Admin login successful', ['admin_id' => $admin->id]);
            
            Auth::guard('admin')->login($admin);
            $request->session()->regenerate();
            
            // Set admin session data
            session([
                'admin_logged_in' => true,
                'user_id' => $admin->id,
                'user_email' => $admin->email,
                'user_name' => $admin->name,
                'user_role' => $admin->role,
                'user_type' => 'admin'
            ]);

            Log::info('Redirecting to admin dashboard');
            return redirect()->route('admin.dashboard')->with('success', 'تم تسجيل الدخول بنجاح!');
        } else {
            return back()->withErrors([
                'email' => 'بيانات تسجيل الدخول غير صحيحة.',
            ])->onlyInput('email');
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'تم تسجيل الخروج بنجاح!');
    }
}
