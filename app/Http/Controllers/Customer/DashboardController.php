<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PortfolioItem;
use App\Models\Testimonial;
use App\Models\CompanyPlan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // طلبات العميل
        $orders = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // إحصائيات الطلبات
        $orderStats = [
            'total' => $orders->count(),
            'pending' => $orders->where('status', 'pending')->count(),
            'processing' => $orders->where('status', 'processing')->count(),
            'shipped' => $orders->where('status', 'shipped')->count(),
            'delivered' => $orders->where('status', 'delivered')->count(),
            'cancelled' => $orders->where('status', 'cancelled')->count(),
        ];

        // إجمالي المبلغ المنفق
        $totalSpent = $orders->where('status', '!=', 'cancelled')->sum('total');

        // الطلبات الحديثة
        $recentOrders = $orders->take(5);

        // معرض الأعمال
        $portfolio = PortfolioItem::where('is_featured', true)
            ->orderBy('sort_order')
            ->limit(6)
            ->get();

        // التقييمات
        $testimonials = Testimonial::where('is_active', true)
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        // خطط الشركة
        $plans = CompanyPlan::where('is_active', true)
            ->orderBy('price')
            ->get();

        // النشاط الأخير
        $recentActivity = collect();

        // إضافة الطلبات الجديدة
        $recentOrders->each(function ($order) use ($recentActivity) {
            $recentActivity->push([
                'type' => 'order',
                'title' => 'طلب جديد',
                'description' => "طلب رقم {$order->order_number} بقيمة {$order->total} ريال",
                'time' => $order->created_at,
                'icon' => 'fas fa-shopping-cart',
                'color' => 'success'
            ]);
        });

        return view('customer.dashboard', compact(
            'user',
            'orders',
            'orderStats',
            'totalSpent',
            'recentOrders',
            'portfolio',
            'testimonials',
            'plans',
            'recentActivity'
        ));
    }

    public function orders()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    public function orderDetails(Order $order)
    {
        $user = Auth::user();
        
        // التحقق من أن الطلب يخص العميل
        if ($order->user_id !== $user->id) {
            return redirect()->back()->with('error', 'ليس لديك صلاحية لعرض هذا الطلب');
        }

        $orderItems = OrderItem::where('order_id', $order->id)->get();

        return view('customer.orders.details', compact('order', 'orderItems'));
    }

    public function createOrder()
    {
        $plans = CompanyPlan::where('is_active', true)->get();
        
        return view('customer.orders.create', compact('plans'));
    }

    public function storeOrder(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'plan_id' => 'required|exists:company_plans,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:1000',
        ]);

        $plan = CompanyPlan::findOrFail($request->plan_id);
        
        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'ORD-' . str_pad(Order::count() + 1, 6, '0', STR_PAD_LEFT),
            'status' => 'pending',
            'subtotal' => $plan->price * $request->quantity,
            'tax' => ($plan->price * $request->quantity) * 0.15,
            'shipping' => 50, // رسوم الشحن الثابتة
            'total' => ($plan->price * $request->quantity) * 1.15 + 50,
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'customer_phone' => $user->phone,
            'shipping_address' => $user->address . '، ' . $user->city,
            'notes' => $request->notes,
        ]);

        return redirect()->route('customer.orders.details', $order)
            ->with('success', 'تم إنشاء الطلب بنجاح');
    }

    public function portfolio()
    {
        $portfolio = PortfolioItem::where('is_active', true)
            ->orderBy('sort_order')
            ->paginate(12);

        return view('customer.portfolio', compact('portfolio'));
    }

    public function testimonials()
    {
        $testimonials = Testimonial::where('is_active', true)
            ->orderBy('sort_order')
            ->paginate(10);

        return view('customer.testimonials', compact('testimonials'));
    }

    public function plans()
    {
        $plans = CompanyPlan::where('is_active', true)
            ->orderBy('price')
            ->get();

        return view('customer.plans', compact('plans'));
    }

    public function profile()
    {
        $user = Auth::user();

        return view('customer.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
        ]);

        $user->update($request->only(['name', 'email', 'phone', 'address', 'city']));

        return redirect()->back()->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }

    public function contact()
    {
        return view('customer.contact');
    }

    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // هنا يمكن إضافة منطق إرسال الرسالة
        // مثل إرسال إيميل أو حفظ في قاعدة البيانات

        return redirect()->back()->with('success', 'تم إرسال رسالتك بنجاح، سنتواصل معك قريباً');
    }
}