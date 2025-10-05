<?php

namespace App\Http\Controllers\Importer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Importer;
use App\Models\ImporterOrder;
use App\Models\Task;
use App\Models\PortfolioItem;
use App\Models\CompanyPlan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $importer = $user->importer;

        if (!$importer) {
            return redirect()->route('login')->with('error', 'لا يمكن الوصول إلى لوحة التحكم');
        }

        // طلبات المستورد
        $orders = ImporterOrder::where('importer_id', $importer->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // إحصائيات الطلبات
        $orderStats = [
            'total' => $orders->count(),
            'new' => $orders->where('status', 'new')->count(),
            'processing' => $orders->where('status', 'processing')->count(),
            'completed' => $orders->where('status', 'completed')->count(),
            'cancelled' => $orders->where('status', 'cancelled')->count(),
        ];

        // إجمالي قيمة الطلبات
        $totalValue = $orders->where('status', '!=', 'cancelled')->sum('final_cost');

        // الطلبات الحديثة
        $recentOrders = $orders->take(5);

        // المهام المرتبطة بالمستورد
        $tasks = Task::where('importer_id', $importer->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // إحصائيات المهام
        $taskStats = [
            'total' => $tasks->count(),
            'pending' => $tasks->where('status', 'pending')->count(),
            'in_progress' => $tasks->where('status', 'in_progress')->count(),
            'completed' => $tasks->where('status', 'completed')->count(),
        ];

        // معرض الأعمال
        $portfolio = PortfolioItem::where('is_featured', true)
            ->orderBy('sort_order')
            ->limit(6)
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
                'description' => "طلب رقم {$order->order_number} بقيمة {$order->final_cost} ريال",
                'time' => $order->created_at,
                'icon' => 'fas fa-shopping-cart',
                'color' => 'success'
            ]);
        });

        // إضافة المهام الجديدة
        $tasks->take(5)->each(function ($task) use ($recentActivity) {
            $recentActivity->push([
                'type' => 'task',
                'title' => 'مهمة جديدة',
                'description' => $task->title,
                'time' => $task->created_at,
                'icon' => 'fas fa-tasks',
                'color' => 'warning'
            ]);
        });

        // ترتيب النشاط حسب الوقت
        $recentActivity = $recentActivity->sortByDesc('time')->take(10);

        return view('importer.dashboard', compact(
            'user',
            'importer',
            'orders',
            'orderStats',
            'totalValue',
            'recentOrders',
            'tasks',
            'taskStats',
            'portfolio',
            'plans',
            'recentActivity'
        ));
    }

    public function orders()
    {
        $user = Auth::user();
        $importer = $user->importer;

        if (!$importer) {
            return redirect()->route('login')->with('error', 'لا يمكن الوصول إلى لوحة التحكم');
        }

        $orders = ImporterOrder::where('importer_id', $importer->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('importer.orders.index', compact('orders'));
    }

    public function orderDetails(ImporterOrder $order)
    {
        $user = Auth::user();
        $importer = $user->importer;

        // التحقق من أن الطلب يخص المستورد
        if ($order->importer_id !== $importer->id) {
            return redirect()->back()->with('error', 'ليس لديك صلاحية لعرض هذا الطلب');
        }

        return view('importer.orders.details', compact('order'));
    }

    public function createOrder()
    {
        $plans = CompanyPlan::where('is_active', true)->get();
        
        return view('importer.orders.create', compact('plans'));
    }

    public function storeOrder(Request $request)
    {
        $user = Auth::user();
        $importer = $user->importer;

        if (!$importer) {
            return redirect()->route('login')->with('error', 'لا يمكن الوصول إلى لوحة التحكم');
        }

        $request->validate([
            'requirements' => 'required|string|max:2000',
            'quantity' => 'required|integer|min:1',
            'design_details' => 'required|string|max:2000',
            'estimated_cost' => 'required|numeric|min:0',
            'delivery_date' => 'required|date|after:today',
            'notes' => 'nullable|string|max:1000',
        ]);

        $order = ImporterOrder::create([
            'importer_id' => $importer->id,
            'order_number' => 'IMP-' . str_pad(ImporterOrder::count() + 1, 6, '0', STR_PAD_LEFT),
            'status' => 'new',
            'requirements' => $request->requirements,
            'quantity' => $request->quantity,
            'design_details' => json_encode([
                'details' => $request->design_details,
                'colors' => $request->colors ?? [],
                'sizes' => $request->sizes ?? [],
                'materials' => $request->materials ?? [],
            ]),
            'estimated_cost' => $request->estimated_cost,
            'final_cost' => $request->estimated_cost,
            'delivery_date' => $request->delivery_date,
            'notes' => $request->notes,
        ]);

        return redirect()->route('importer.orders.details', $order)
            ->with('success', 'تم إنشاء الطلب بنجاح');
    }

    public function tasks()
    {
        $user = Auth::user();
        $importer = $user->importer;

        if (!$importer) {
            return redirect()->route('login')->with('error', 'لا يمكن الوصول إلى لوحة التحكم');
        }

        $tasks = Task::where('importer_id', $importer->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('importer.tasks.index', compact('tasks'));
    }

    public function portfolio()
    {
        $portfolio = PortfolioItem::where('is_active', true)
            ->orderBy('sort_order')
            ->paginate(12);

        return view('importer.portfolio', compact('portfolio'));
    }

    public function plans()
    {
        $plans = CompanyPlan::where('is_active', true)
            ->orderBy('price')
            ->get();

        return view('importer.plans', compact('plans'));
    }

    public function profile()
    {
        $user = Auth::user();
        $importer = $user->importer;

        return view('importer.profile', compact('user', 'importer'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $importer = $user->importer;

        if (!$importer) {
            return redirect()->route('login')->with('error', 'لا يمكن الوصول إلى لوحة التحكم');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'company_name' => 'required|string|max:255',
            'business_type' => 'required|string|max:100',
            'business_type_other' => 'nullable|string|max:255',
            'country' => 'required|string|max:100',
            'notes' => 'nullable|string|max:1000',
        ]);

        $user->update($request->only(['name', 'email', 'phone', 'address', 'city']));
        
        $importer->update($request->only([
            'company_name', 'business_type', 'business_type_other', 
            'country', 'notes'
        ]));

        return redirect()->back()->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }

    public function contact()
    {
        return view('importer.contact');
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