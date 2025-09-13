<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\CustomDesign;
use App\Models\Product;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'user.type:customer']);
    }

    public function dashboard()
    {
        $user = Auth::user();
        
        // Get customer statistics
        $totalOrders = Order::where('user_id', $user->id)->count();
        $pendingOrders = Order::where('user_id', $user->id)->where('status', 'pending')->count();
        $completedOrders = Order::where('user_id', $user->id)->where('status', 'completed')->count();
        $totalDesigns = CustomDesign::where('user_id', $user->id)->count();
        
        // Get recent orders
        $recentOrders = Order::where('user_id', $user->id)
            ->with('product')
            ->latest()
            ->take(5)
            ->get();
            
        // Get recent custom designs
        $recentDesigns = CustomDesign::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();
            
        // Get favorite products
        $featuredProducts = Product::where('is_featured', true)
            ->where('is_active', true)
            ->take(6)
            ->get();

        return view('customer.dashboard', compact(
            'user',
            'totalOrders',
            'pendingOrders', 
            'completedOrders',
            'totalDesigns',
            'recentOrders',
            'recentDesigns',
            'featuredProducts'
        ));
    }

    public function orders()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
            ->with('product')
            ->latest()
            ->paginate(10);

        return view('customer.orders', compact('orders'));
    }

    public function designs()
    {
        $user = Auth::user();
        $designs = CustomDesign::where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('customer.designs', compact('designs'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('customer.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
        ]);

        $user->update($validatedData);

        return redirect()->route('customer.profile')
            ->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }

    public function settings()
    {
        $user = Auth::user();
        return view('customer.settings', compact('user'));
    }
}