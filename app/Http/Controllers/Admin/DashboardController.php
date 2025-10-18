<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Importer;
use App\Models\TaskCard;
use App\Models\Transaction;
use App\Models\ImporterOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        
        // إحصائيات عامة
        $stats = [
            'total_users' => User::count(),
            'total_employees' => 0, // Employee table doesn't exist yet
            'total_importers' => Importer::count(),
            'total_tasks' => TaskCard::count(),
            'total_transactions' => Transaction::count(),
            'total_importer_orders' => ImporterOrder::count(),
        ];

        // إحصائيات المبيعات الشهرية
        $monthlySales = ImporterOrder::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
        ->whereRaw('YEAR(created_at) = ?', [Carbon::now()->year])
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        // إحصائيات المعاملات المالية
        $financialStats = [
            'total_income' => Transaction::where('type', 'income')->sum('amount'),
            'total_expenses' => Transaction::where('type', 'expense')->sum('amount'),
            'monthly_income' => Transaction::where('type', 'income')
                ->whereRaw('MONTH(transaction_date) = ?', [Carbon::now()->month])
                ->whereRaw('YEAR(transaction_date) = ?', [Carbon::now()->year])
                ->sum('amount'),
            'monthly_expenses' => Transaction::where('type', 'expense')
                ->whereRaw('MONTH(transaction_date) = ?', [Carbon::now()->month])
                ->whereRaw('YEAR(transaction_date) = ?', [Carbon::now()->year])
                ->sum('amount'),
        ];

        // الطلبات الحديثة
        $recentOrders = ImporterOrder::with('importer.user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // المهام المعلقة
        $pendingTasks = TaskCard::with(['assignedUser', 'board'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // المستوردين الجدد
        $newImporters = Importer::where('status', 'new')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // إحصائيات الطلبات حسب الحالة
        $orderStats = ImporterOrder::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // إحصائيات المهام حسب الأولوية
        $taskStats = TaskCard::select('priority', DB::raw('count(*) as count'))
            ->groupBy('priority')
            ->get();

        // النشاط الأخير
        $recentActivity = collect();

        // إضافة الطلبات الجديدة
        $recentOrders->each(function ($order) use ($recentActivity) {
            $recentActivity->push([
                'type' => 'order',
                'title' => 'طلب جديد',
                'description' => "طلب جديد من {$order->customer_name} بقيمة {$order->total} ريال",
                'time' => $order->created_at,
                'icon' => 'fas fa-shopping-cart',
                'color' => 'success'
            ]);
        });

        // إضافة المهام الجديدة
        $pendingTasks->each(function ($task) use ($recentActivity) {
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

        return view('admin.dashboard', compact(
            'stats',
            'monthlySales',
            'financialStats',
            'recentOrders',
            'pendingTasks',
            'newImporters',
            'orderStats',
            'taskStats',
            'recentActivity'
        ));
    }

    public function users()
    {
        $users = User::with(['roles'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function employees()
    {
        // Employee table doesn't exist yet - redirect to dashboard
        return redirect()->route('admin.dashboard')->with('info', 'قسم الموظفين غير متاح حالياً');
    }


    public function importers()
    {
        $importers = Importer::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.importers.index', compact('importers'));
    }

    public function tasks()
    {
        $tasks = TaskCard::with(['assignedUser', 'creator'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // إحصائيات المهام
        $stats = [
            'total' => TaskCard::count(),
            'pending' => TaskCard::where('status', 'pending')->count(),
            'in_progress' => TaskCard::where('status', 'in_progress')->count(),
            'completed' => TaskCard::where('status', 'completed')->count(),
            'overdue' => TaskCard::where('due_date', '<', now())
                ->where('status', '!=', 'completed')
                ->count(),
        ];

        return view('admin.tasks.index', compact('tasks', 'stats'));
    }


    public function reports()
    {
        return view('admin.reports');
    }

    public function settings()
    {
        return view('admin.settings');
    }
}