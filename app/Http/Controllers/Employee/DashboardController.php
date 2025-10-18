<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;
use App\Models\Order;
use App\Models\Task;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $employee = $user->employee;

        if (!$employee) {
            return redirect()->route('login')->with('error', 'لا يمكن الوصول إلى لوحة التحكم');
        }

        // المهام المخصصة للموظف
        $myTasks = Task::where('assigned_to', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // إحصائيات المهام
        $taskStats = [
            'total' => $myTasks->count(),
            'pending' => $myTasks->where('status', 'pending')->count(),
            'in_progress' => $myTasks->where('status', 'in_progress')->count(),
            'completed' => $myTasks->where('status', 'completed')->count(),
            'overdue' => $myTasks->where('due_date', '<', Carbon::now())
                ->where('status', '!=', 'completed')->count(),
        ];

        // المهام العاجلة
        $urgentTasks = $myTasks->where('priority', 'urgent')
            ->where('status', '!=', 'completed')
            ->take(5);

        // المهام المستحقة قريباً
        $upcomingTasks = $myTasks->where('due_date', '>=', Carbon::now())
            ->where('due_date', '<=', Carbon::now()->addDays(7))
            ->where('status', '!=', 'completed')
            ->take(5);

        // الطلبات المرتبطة بالموظف (إذا كان لديه صلاحية)
        $relatedOrders = collect();
        if ($user->hasPermission('orders.view')) {
            $relatedOrders = Order::orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
        }

        // المعاملات المالية المرتبطة بالموظف (إذا كان لديه صلاحية)
        $relatedTransactions = collect();
        if ($user->hasPermission('transactions.view')) {
            $relatedTransactions = Transaction::where('created_by', $user->id)
                ->orderBy('transaction_date', 'desc')
                ->limit(10)
                ->get();
        }

        // إحصائيات الأداء الشهرية
        $monthlyPerformance = [
            'tasks_completed' => Task::where('assigned_to', $user->id)
                ->where('status', 'completed')
                ->whereRaw('strftime("%m", completed_at) = ?', [str_pad(Carbon::now()->month, 2, '0', STR_PAD_LEFT)])
                ->whereRaw('strftime("%Y", completed_at) = ?', [Carbon::now()->year])
                ->count(),
            'hours_worked' => Task::where('assigned_to', $user->id)
                ->where('status', 'completed')
                ->whereRaw('strftime("%m", completed_at) = ?', [str_pad(Carbon::now()->month, 2, '0', STR_PAD_LEFT)])
                ->whereRaw('strftime("%Y", completed_at) = ?', [Carbon::now()->year])
                ->sum('actual_hours'),
        ];

        // النشاط الأخير
        $recentActivity = collect();

        // إضافة المهام المكتملة
        $myTasks->where('status', 'completed')->take(5)->each(function ($task) use ($recentActivity) {
            $recentActivity->push([
                'type' => 'task_completed',
                'title' => 'مهمة مكتملة',
                'description' => $task->title,
                'time' => $task->completed_at,
                'icon' => 'fas fa-check-circle',
                'color' => 'success'
            ]);
        });

        // إضافة المهام الجديدة
        $myTasks->where('status', 'pending')->take(5)->each(function ($task) use ($recentActivity) {
            $recentActivity->push([
                'type' => 'task_assigned',
                'title' => 'مهمة جديدة',
                'description' => $task->title,
                'time' => $task->created_at,
                'icon' => 'fas fa-tasks',
                'color' => 'warning'
            ]);
        });

        // ترتيب النشاط حسب الوقت
        $recentActivity = $recentActivity->sortByDesc('time')->take(10);

        return view('employee.dashboard', compact(
            'employee',
            'myTasks',
            'taskStats',
            'urgentTasks',
            'upcomingTasks',
            'relatedOrders',
            'relatedTransactions',
            'monthlyPerformance',
            'recentActivity'
        ));
    }

    public function tasks()
    {
        $user = Auth::user();
        $tasks = Task::where('assigned_to', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('employee.tasks.index', compact('tasks'));
    }

    public function updateTaskStatus(Request $request, Task $task)
    {
        $user = Auth::user();
        
        // التحقق من أن المهمة مخصصة للموظف
        if ($task->assigned_to !== $user->id) {
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

        return redirect()->back()->with('success', 'تم تحديث حالة المهمة بنجاح');
    }

    public function profile()
    {
        $user = Auth::user();
        $employee = $user->employee;

        return view('employee.profile', compact('user', 'employee'));
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

        $user->update($request->only(['name', 'email', 'phone', 'address', 'city', 'bio']));

        return redirect()->back()->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }
}