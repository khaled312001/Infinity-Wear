<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Importer;
use App\Models\ImporterOrder;
use App\Models\TaskCard;
use App\Models\Transaction;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        try {
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
                    ->whereRaw('strftime("%m", created_at) = ?', [str_pad(Carbon::now()->month, 2, '0', STR_PAD_LEFT)])
                    ->whereRaw('strftime("%Y", created_at) = ?', [Carbon::now()->year])
                    ->sum('final_cost'),
            ];

            // المستوردين الجدد
            $newImporters = Importer::where('status', 'new')
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();

            // المهام المرتبطة بالمبيعات
            $tasks = TaskCard::where('department', 'sales')
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
            DB::raw('strftime("%m", created_at) as month'),
            DB::raw('SUM(final_cost) as total')
        )
        ->whereRaw('strftime("%Y", created_at) = ?', [Carbon::now()->year])
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
        
        } catch (\Exception $e) {
            \Log::error('Sales dashboard error: ' . $e->getMessage());
            
            // Return empty data if database is unavailable
            $user = Auth::user();
            $importerOrders = collect();
            $importers = collect();
            $salesStats = [
                'total_importers' => 0,
                'total_importer_orders' => 0,
                'total_importer_revenue' => 0,
                'monthly_importer_revenue' => 0,
            ];
            $newImporters = collect();
            $tasks = collect();
            $taskStats = [
                'total' => 0,
                'pending' => 0,
                'in_progress' => 0,
                'completed' => 0,
            ];
            $urgentTasks = collect();
            $recentImporterOrders = collect();
            $monthlySales = collect();
            $importerStats = collect();
            $recentActivity = collect();
            
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
            ))->with('error', 'لا يمكن تحميل البيانات حالياً. يرجى المحاولة لاحقاً.');
        }
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
        $tasks = TaskCard::where('department', 'sales')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('sales.tasks.index', compact('tasks'));
    }

    public function updateTaskStatus(Request $request, TaskCard $task)
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
        // تقارير المبيعات (طلبات المستوردين فقط)
        $monthlyReport = ImporterOrder::select(
            DB::raw('strftime("%m", created_at) as month'),
            DB::raw('COUNT(*) as orders_count'),
            DB::raw('SUM(final_cost) as total_revenue')
        )
        ->whereRaw('strftime("%Y", created_at) = ?', [Carbon::now()->year])
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

    public function contacts(Request $request)
    {
        $query = Contact::notArchived()->forSales()->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by contact type
        if ($request->filled('contact_type')) {
            $query->where('contact_type', $request->contact_type);
        }

        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Filter by source
        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        // Filter by tags
        if ($request->filled('tags')) {
            $query->byTags($request->tags);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $contacts = $query->paginate(20);

        // Statistics
        $stats = [
            'total' => Contact::notArchived()->forSales()->count(),
            'new' => Contact::notArchived()->forSales()->new()->count(),
            'read' => Contact::notArchived()->forSales()->read()->count(),
            'replied' => Contact::notArchived()->forSales()->replied()->count(),
            'closed' => Contact::notArchived()->forSales()->closed()->count(),
            'inquiry' => Contact::notArchived()->forSales()->inquiry()->count(),
            'custom' => Contact::notArchived()->forSales()->custom()->count(),
            'high_priority' => Contact::notArchived()->forSales()->byPriority('high')->count(),
            'follow_up_today' => Contact::notArchived()->forSales()->whereDate('follow_up_date', today())->count(),
        ];

        return view('sales.contacts.index', compact('contacts', 'stats'));
    }

    public function showContact(Contact $contact)
    {
        // Mark as read if it's new
        if ($contact->status === 'new') {
            $contact->markAsRead();
        }

        return view('sales.contacts.show', compact('contact'));
    }

    public function updateContact(Request $request, Contact $contact)
    {
        $request->validate([
            'status' => 'required|in:new,read,replied,closed',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $contact->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'read_at' => $request->status === 'read' && !$contact->read_at ? now() : $contact->read_at,
            'replied_at' => $request->status === 'replied' && !$contact->replied_at ? now() : $contact->replied_at,
        ]);

        return redirect()->back()->with('success', 'تم تحديث جهة الاتصال بنجاح');
    }
}