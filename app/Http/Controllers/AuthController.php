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
        // Regenerate session to ensure fresh CSRF token
        request()->session()->regenerate();
        
        // Check the current route to determine which login form to show
        $routeName = request()->route()->getName();
        
        if ($routeName === 'marketing.login') {
            return view('auth.marketing-login');
        } elseif ($routeName === 'sales.login') {
            return view('auth.sales-login');
        }
        
        // Default to regular customer login
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Debug: Log all request data
        \Log::info('Login request data', $request->all());
        
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed', $e->errors());
            throw $e;
        }

        // Debug logging
        \Log::info('Login attempt', [
            'email' => $credentials['email']
        ]);

        try {
            // Attempt login for all user types
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                
                // Redirect to appropriate dashboard based on user type
                $user = Auth::user();
                \Log::info('Login successful', ['user_id' => $user->id, 'user_type' => $user->user_type]);
                
                // Check if user is trying to access the correct login route
                $routeName = $request->route()->getName();
                
                // Restrict access based on route and user type
                if ($routeName === 'marketing.login.post' && $user->user_type !== 'marketing') {
                    Auth::logout();
                    return back()->withErrors([
                        'email' => 'هذا الحساب غير مسموح له بالوصول إلى لوحة تحكم التسويق.',
                    ])->onlyInput('email');
                }
                
                if ($routeName === 'sales.login.post' && $user->user_type !== 'sales') {
                    Auth::logout();
                    return back()->withErrors([
                        'email' => 'هذا الحساب غير مسموح له بالوصول إلى لوحة تحكم المبيعات.',
                    ])->onlyInput('email');
                }
                
                // Special handling for importer users
                if ($user->user_type === 'importer') {
                    try {
                        // Check if importer profile exists
                        $importer = \App\Models\Importer::where('user_id', $user->id)->first();
                        if (!$importer) {
                            \Log::info('Importer profile not found, redirecting to form', ['user_id' => $user->id]);
                            return redirect()->route('importers.form')
                                ->with('info', 'يرجى إكمال بيانات المستورد أولاً');
                        }
                    } catch (\Exception $e) {
                        \Log::warning('Database unavailable for importer check, proceeding with login: ' . $e->getMessage());
                        // Continue with login even if importer check fails
                    }
                }
                
                return redirect()->route($user->getDashboardRoute());
            }

            return back()->withErrors([
                'email' => 'البيانات المدخلة غير صحيحة.',
            ])->onlyInput('email');
            
        } catch (\Illuminate\Database\QueryException $e) {
            if (strpos($e->getMessage(), 'max_connections_per_hour') !== false) {
                \Log::error('Database connection limit exceeded during login', [
                    'email' => $credentials['email'],
                    'error' => $e->getMessage()
                ]);
                
                return back()->withErrors([
                    'email' => 'خدمة تسجيل الدخول غير متاحة مؤقتاً. يرجى المحاولة لاحقاً.',
                ])->with('error', 'تم تجاوز حد الاتصالات بقاعدة البيانات. يرجى المحاولة بعد ساعة واحدة.');
            }
            
            // Re-throw other database exceptions
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Unexpected error during login', [
                'email' => $credentials['email'],
                'error' => $e->getMessage()
            ]);
            
            return back()->withErrors([
                'email' => 'حدث خطأ غير متوقع. يرجى المحاولة لاحقاً.',
            ])->with('error', 'خطأ في النظام. يرجى المحاولة لاحقاً.');
        }
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