<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Debug: Log all request data
        \Log::info('Customer login request data', $request->all());
        
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Customer validation failed', $e->errors());
            throw $e;
        }

        // Debug logging
        \Log::info('Customer login attempt', [
            'email' => $credentials['email']
        ]);

        // Customer login only
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Redirect to appropriate dashboard based on user type
            $user = Auth::user();
            \Log::info('Customer login successful', ['user_id' => $user->id, 'user_type' => $user->user_type]);
            return redirect()->route($user->getDashboardRoute());
        }

        return back()->withErrors([
            'email' => 'البيانات المدخلة غير صحيحة.',
        ])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['user_type'] = 'customer';

        $user = User::create($validatedData);

        Auth::login($user);

        return redirect()->route($user->getDashboardRoute())->with('success', 'تم إنشاء الحساب بنجاح!');
    }

    public function logout(Request $request)
    {
        // Logout from both guards
        Auth::logout();
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'تم تسجيل الخروج بنجاح!');
    }
} 