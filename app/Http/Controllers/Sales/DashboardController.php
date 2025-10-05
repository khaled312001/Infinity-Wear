<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Importer;
use App\Models\ImporterOrder;
use App\Models\Task;
use App\Models\Transaction;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // طلبات المستوردين فقط
        $importerOrders = ImporterOrder::orderBy('created_at', 'desc')->get();
        $importers = Importer::orderBy('created_at', 'desc')->get();

        // إحصائيات المبيعات (المستوردين فقط)
        $salesStats = [
            'total_importers' => $importers->count(),
            'total_importer_orders' => $importerOrders->count(),
            'total_importer_revenue' => $importerOrders->where('status', '!=', 'cancelled')->sum('final_cost'),
            'monthly_importer_revenue' => ImporterOrder::where('status', '!=', 'cancelled')
                ->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->sum('final_cost'),
        ];

        // المستوردين الجدد
        $newImporters = Importer::where('status', 'new')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // المهام المرتبطة بالمبيعات
        $tasks = Task::where('department', 'sales')
            ->orderBy('created_at', 'desc')
            ->get();

        // إحصائيات المهام
        $taskStats = [
            'total' => $tasks->count(),
            'pending' => $tasks->where('status', 'pending')->count(),
            'in_progress' => $tasks->where('status', 'in_progress')->count(),
            'completed' => $tasks->where('status', 'completed')->count(),
        ];

        // المهام العاجلة
        $urgentTasks = $tasks->where('priority', 'urgent')
            ->where('status', '!=', 'completed')
            ->take(5);

        // طلبات المستوردين الحديثة
        $recentImporterOrders = $importerOrders->take(5);

        // إحصائيات المبيعات الشهرية (طلبات المستوردين)
        $monthlySales = ImporterOrder::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(final_cost) as total')
        )
        ->whereYear('created_at', Carbon::now()->year)
        ->where('status', '!=', 'cancelled')
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        // إحصائيات المستوردين حسب الحالة
        $importerStats = Importer::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // النشاط الأخير
        $recentActivity = collect();

        // إضافة طلبات المستوردين الجديدة
        $recentImporterOrders->each(function ($order) use ($recentActivity) {
            $recentActivity->push([
                'type' => 'importer_order',
                'title' => 'طلب مستورد جديد',
                'description' => "طلب رقم {$order->order_number} بقيمة {$order->final_cost} ريال",
                'time' => $order->created_at,
                'icon' => 'fas fa-industry',
                'color' => 'info'
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

        return view('sales.dashboard', compact(
            'user',
            'importerOrders',
            'importers',
            'salesStats',
            'newImporters',
            'tasks',
            'taskStats',
            'urgentTasks',
            'recentImporterOrders',
            'monthlySales',
            'importerStats',
            'recentActivity'
        ));
    }

    public function orders()
    {
        $orders = Order::orderBy('created_at', 'desc')
            ->paginate(20);

        return view('sales.orders.index', compact('orders'));
    }

    public function importers()
    {
        $importers = Importer::orderBy('created_at', 'desc')
            ->paginate(20);

        return view('sales.importers.index', compact('importers'));
    }

    public function importerOrders()
    {
        $orders = ImporterOrder::orderBy('created_at', 'desc')
            ->paginate(20);

        return view('sales.importer-orders.index', compact('orders'));
    }

    public function tasks()
    {
        $tasks = Task::where('department', 'sales')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('sales.tasks.index', compact('tasks'));
    }

    public function updateTaskStatus(Request $request, Task $task)
    {
        $user = Auth::user();
        
        // التحقق من أن المهمة مرتبطة بالمبيعات
        if ($task->department !== 'sales') {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'ليس لديك صلاحية لتعديل هذه المهمة'], 403);
            }
            return redirect()->back()->with('error', 'ليس لديك صلاحية لتعديل هذه المهمة');
        }

        $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
            'notes' => 'nullable|string|max:1000'
        ]);

        $task->update([
            'status' => $request->status,
            'notes' => $request->notes,
            'completed_at' => $request->status === 'completed' ? Carbon::now() : null,
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'تم تحديث حالة المهمة بنجاح']);
        }

        return redirect()->back()->with('success', 'تم تحديث حالة المهمة بنجاح');
    }

    public function reports()
    {
        // تقارير المبيعات
        $monthlyReport = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as orders_count'),
            DB::raw('SUM(total) as total_revenue')
        )
        ->whereYear('created_at', Carbon::now()->year)
        ->where('status', '!=', 'cancelled')
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        $importerReport = Importer::select(
            'status',
            DB::raw('COUNT(*) as count')
        )
        ->groupBy('status')
        ->get();

        return view('sales.reports', compact('monthlyReport', 'importerReport'));
    }

    public function profile()
    {
        $user = Auth::user();

        return view('sales.profile', compact('user'));
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
            'bio' => 'nullable|string|max:1000',
        ]);

        // Update user profile
        DB::table('users')->where('id', $user->id)->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'city' => $request->input('city'),
            'bio' => $request->input('bio'),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }

    public function showOrder(Order $order)
    {
        return view('sales.orders.show', compact('order'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
            'notes' => 'nullable|string|max:1000'
        ]);

        $order->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()->back()->with('success', 'تم تحديث حالة الطلب بنجاح');
    }

    public function showImporterOrder(ImporterOrder $order)
    {
        return view('sales.importer-orders.show', compact('order'));
    }

    public function updateImporterOrderStatus(Request $request, ImporterOrder $order)
    {
        $request->validate([
            'status' => 'required|in:new,processing,completed,cancelled',
            'notes' => 'nullable|string|max:1000'
        ]);

        $order->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()->back()->with('success', 'تم تحديث حالة طلب المستورد بنجاح');
    }

    public function showImporter(Importer $importer)
    {
        return view('sales.importers.show', compact('importer'));
    }

    public function updateImporterStatus(Request $request, Importer $importer)
    {
        $request->validate([
            'status' => 'required|in:new,contacted,qualified,unqualified',
            'notes' => 'nullable|string|max:1000'
        ]);

        $importer->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()->back()->with('success', 'تم تحديث حالة المستورد بنجاح');
    }

    public function contacts()
    {
        $contacts = DB::table('contacts')->orderBy('created_at', 'desc')->paginate(20);
        return view('sales.contacts.index', compact('contacts'));
    }

    public function showContact($id)
    {
        $contact = DB::table('contacts')->where('id', $id)->first();
        if (!$contact) {
            return redirect()->route('sales.contacts')->with('error', 'جهة الاتصال غير موجودة');
        }
        return view('sales.contacts.show', compact('contact'));
    }

    public function updateContact(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'status' => 'required|in:new,read,replied,closed',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        DB::table('contacts')->where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'company' => $request->company,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'تم تحديث جهة الاتصال بنجاح');
    }
}