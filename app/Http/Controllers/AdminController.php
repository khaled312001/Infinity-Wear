<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\CustomDesign;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * لوحة التحكم الرئيسية
     */
    public function dashboard()
    {
        // الإحصائيات العامة
        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'total_categories' => Category::count(),
            'active_categories' => Category::where('is_active', true)->count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'completed_orders' => Order::where('status', 'completed')->count(),
            'processing_orders' => Order::where('status', 'processing')->count(),
            'total_custom_designs' => CustomDesign::count(),
            'total_users' => User::count(),
            'total_revenue' => Order::where('status', 'completed')->sum('total_amount'),
            'monthly_revenue' => Order::where('status', 'completed')
                ->whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->sum('total_amount'),
        ];

        // الطلبات الأخيرة
        $recentOrders = Order::with('user')
            ->latest()
            ->take(10)
            ->get();

        // المنتجات منخفضة المخزون
        $lowStockProducts = Product::where('stock_quantity', '<=', 10)
            ->where('is_active', true)
            ->take(5)
            ->get();

        // التصاميم المخصصة الأخيرة
        $recentDesigns = CustomDesign::with('user')
            ->latest()
            ->take(5)
            ->get();

        // إحصائيات المبيعات الشهرية
        $monthlySales = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_amount) as total')
        )
        ->where('status', 'completed')
        ->whereYear('created_at', date('Y'))
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month');

        // أكثر المنتجات مبيعاً
        $topProducts = Product::select('products.*', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->groupBy('products.id')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'lowStockProducts',
            'recentDesigns',
            'monthlySales',
            'topProducts'
        ));
    }

    /**
     * عرض التقارير
     */
    public function reports()
    {
        // تقرير المبيعات
        $salesReport = [
            'daily_sales' => Order::where('status', 'completed')
                ->whereDate('created_at', today())
                ->sum('total_amount'),
            'weekly_sales' => Order::where('status', 'completed')
                ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->sum('total_amount'),
            'monthly_sales' => Order::where('status', 'completed')
                ->whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->sum('total_amount'),
            'yearly_sales' => Order::where('status', 'completed')
                ->whereYear('created_at', date('Y'))
                ->sum('total_amount'),
        ];

        // تقرير المنتجات
        $productsReport = [
            'total_products' => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'inactive_products' => Product::where('is_active', false)->count(),
            'featured_products' => Product::where('is_featured', true)->count(),
            'low_stock_products' => Product::where('stock_quantity', '<=', 10)->count(),
            'out_of_stock_products' => Product::where('stock_quantity', 0)->count(),
        ];

        // تقرير العملاء
        $customersReport = [
            'total_customers' => User::count(),
            'active_customers' => User::whereHas('orders')->count(),
            'new_customers_this_month' => User::whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->count(),
        ];

        return view('admin.reports', compact(
            'salesReport',
            'productsReport',
            'customersReport'
        ));
    }

    /**
     * إدارة العملاء
     */
    public function customers()
    {
        $customers = User::withCount('orders')
            ->with(['orders' => function($query) {
                $query->where('status', 'completed');
            }])
            ->paginate(20);

        return view('admin.customers', compact('customers'));
    }

    /**
     * الإعدادات العامة
     */
    public function settings()
    {
        return view('admin.settings');
    }

    /**
     * تحديث الإعدادات
     */
    public function updateSettings(Request $request)
    {
        $validatedData = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'required|string',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string',
            'address' => 'required|string',
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
        ]);

        // حفظ الإعدادات في قاعدة البيانات أو ملف التكوين
        foreach ($validatedData as $key => $value) {
            // يمكن حفظها في جدول الإعدادات
            DB::table('settings')->updateOrInsert(
                ['key' => $key],
                ['value' => $value, 'updated_at' => now()]
            );
        }

        return redirect()->route('admin.settings')
            ->with('success', 'تم تحديث الإعدادات بنجاح');
    }
}
