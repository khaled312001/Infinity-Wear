<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\MarketingTeam;
use App\Models\SalesTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * عرض قائمة المهام (للإدارة)
     */
    public function index()
    {
        // إذا كان المستخدم مدير عام، اعرض جميع المهام
        if (Auth::guard('admin')->check()) {
            $tasks = Task::with(['assignedUser', 'assignedBy'])
                ->latest()
                ->paginate(20);
            
            $stats = [
                'total' => Task::count(),
                'pending' => Task::where('status', 'pending')->count(),
                'in_progress' => Task::where('status', 'in_progress')->count(),
                'completed' => Task::where('status', 'completed')->count(),
                'overdue' => Task::where('status', '!=', 'completed')
                    ->where('due_date', '<', now())
                    ->count(),
            ];
            
            return view('admin.tasks.index', compact('tasks', 'stats'));
        }
        
        return $this->userTasks();
    }

    /**
     * عرض قائمة المهام للمستخدم الحالي
     */
    public function userTasks()
    {
        $user = Auth::user();
        $tasks = [];
        
        // تحديد المهام بناءً على دور المستخدم
        if ($user->role === 'admin') {
            $tasks = Task::where('assigned_to', $user->id)
                ->where('assigned_to_type', 'admin')
                ->latest()
                ->paginate(20);
        } elseif ($user->role === 'marketing') {
            $marketingMember = MarketingTeam::where('admin_id', $user->id)->first();
            if ($marketingMember) {
                $tasks = Task::where('assigned_to', $marketingMember->id)
                    ->where('assigned_to_type', 'marketing')
                    ->latest()
                    ->paginate(20);
            }
        } elseif ($user->role === 'sales') {
            $salesMember = SalesTeam::where('admin_id', $user->id)->first();
            if ($salesMember) {
                $tasks = Task::where('assigned_to', $salesMember->id)
                    ->where('assigned_to_type', 'sales')
                    ->latest()
                    ->paginate(20);
            }
        }

        // إحصائيات المهام
        $completedTasks = Task::where('assigned_to', $user->id)
            ->where('assigned_to_type', $user->role === 'admin' ? 'admin' : ($user->role === 'marketing' ? 'marketing' : 'sales'))
            ->where('status', 'completed')
            ->count();

        $pendingTasks = Task::where('assigned_to', $user->id)
            ->where('assigned_to_type', $user->role === 'admin' ? 'admin' : ($user->role === 'marketing' ? 'marketing' : 'sales'))
            ->where('status', 'pending')
            ->count();

        $inProgressTasks = Task::where('assigned_to', $user->id)
            ->where('assigned_to_type', $user->role === 'admin' ? 'admin' : ($user->role === 'marketing' ? 'marketing' : 'sales'))
            ->where('status', 'in_progress')
            ->count();

        return view('tasks.index', compact('tasks', 'completedTasks', 'pendingTasks', 'inProgressTasks'));
    }



    /**
     * إضافة تعليق على المهمة
     */
    public function addComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $user = Auth::user();
        $task = Task::findOrFail($id);

        // التحقق من أن المهمة تنتمي للمستخدم الحالي
        $canComment = false;
        
        if ($user->role === 'admin') {
            if ($task->assigned_to_type === 'admin' && $task->assigned_to === $user->id) {
                $canComment = true;
            }
        } elseif ($user->role === 'marketing') {
            $marketingMember = MarketingTeam::where('admin_id', $user->id)->first();
            if ($marketingMember && $task->assigned_to_type === 'marketing' && $task->assigned_to === $marketingMember->id) {
                $canComment = true;
            }
        } elseif ($user->role === 'sales') {
            $salesMember = SalesTeam::where('admin_id', $user->id)->first();
            if ($salesMember && $task->assigned_to_type === 'sales' && $task->assigned_to === $salesMember->id) {
                $canComment = true;
            }
        } elseif ($user->role === 'super_admin') {
            $canComment = true;
        }

        if (!$canComment) {
            return redirect()->route('tasks.index')
                ->with('error', 'ليس لديك صلاحية للتعليق على هذه المهمة');
        }

        // إضافة التعليق إلى المهمة
        $comments = $task->comments ?? [];
        $comments[] = [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'comment' => $request->comment,
            'created_at' => now()->toDateTimeString(),
        ];

        $task->update(['comments' => $comments]);

        return redirect()->route('tasks.show', $task->id)
            ->with('success', 'تم إضافة التعليق بنجاح');
    }

    /**
     * عرض المهام المكتملة للمستخدم الحالي
     */
    public function completed()
    {
        $user = Auth::user();
        $tasks = [];
        
        // تحديد المهام المكتملة بناءً على دور المستخدم
        if ($user->role === 'admin') {
            $tasks = Task::where('assigned_to', $user->id)
                ->where('assigned_to_type', 'admin')
                ->where('status', 'completed')
                ->latest()
                ->paginate(20);
        } elseif ($user->role === 'marketing') {
            $marketingMember = MarketingTeam::where('admin_id', $user->id)->first();
            if ($marketingMember) {
                $tasks = Task::where('assigned_to', $marketingMember->id)
                    ->where('assigned_to_type', 'marketing')
                    ->where('status', 'completed')
                    ->latest()
                    ->paginate(20);
            }
        } elseif ($user->role === 'sales') {
            $salesMember = SalesTeam::where('admin_id', $user->id)->first();
            if ($salesMember) {
                $tasks = Task::where('assigned_to', $salesMember->id)
                    ->where('assigned_to_type', 'sales')
                    ->where('status', 'completed')
                    ->latest()
                    ->paginate(20);
            }
        }

        return view('tasks.completed', compact('tasks'));
    }

    /**
     * عرض المهام المعلقة للمستخدم الحالي
     */
    public function pending()
    {
        $user = Auth::user();
        $tasks = [];
        
        // تحديد المهام المعلقة بناءً على دور المستخدم
        if ($user->role === 'admin') {
            $tasks = Task::where('assigned_to', $user->id)
                ->where('assigned_to_type', 'admin')
                ->where('status', 'pending')
                ->latest()
                ->paginate(20);
        } elseif ($user->role === 'marketing') {
            $marketingMember = MarketingTeam::where('admin_id', $user->id)->first();
            if ($marketingMember) {
                $tasks = Task::where('assigned_to', $marketingMember->id)
                    ->where('assigned_to_type', 'marketing')
                    ->where('status', 'pending')
                    ->latest()
                    ->paginate(20);
            }
        } elseif ($user->role === 'sales') {
            $salesMember = SalesTeam::where('admin_id', $user->id)->first();
            if ($salesMember) {
                $tasks = Task::where('assigned_to', $salesMember->id)
                    ->where('assigned_to_type', 'sales')
                    ->where('status', 'pending')
                    ->latest()
                    ->paginate(20);
            }
        }

        return view('tasks.pending', compact('tasks'));
    }

    /**
     * عرض نموذج إنشاء مهمة جديدة (للإدارة)
     */
    public function create()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('tasks.index');
        }

        // جلب قائمة المستخدمين الذين يمكن تعيين مهام لهم
        $marketingTeam = MarketingTeam::with('admin')->where('is_active', true)->get();
        $salesTeam = SalesTeam::with('admin')->where('is_active', true)->get();
        $admins = User::where('role', 'admin')->get();

        return view('admin.tasks.create', compact('marketingTeam', 'salesTeam', 'admins'));
    }

    /**
     * حفظ مهمة جديدة (للإدارة)
     */
    public function store(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('tasks.index');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'assigned_to' => 'required|integer',
            'department' => 'required|in:admin,marketing,sales',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'required|date|after_or_equal:today',
        ]);

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'assigned_to' => $request->assigned_to,
            'assigned_by' => Auth::guard('admin')->id(),
            'department' => $request->department,
            'priority' => $request->priority,
            'status' => 'pending',
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('admin.tasks.index')
            ->with('success', 'تم إنشاء المهمة بنجاح');
    }

    /**
     * عرض تفاصيل مهمة (للإدارة)
     */
    public function show($id)
    {
        if (Auth::guard('admin')->check()) {
            $task = Task::with(['assignedUser', 'assignedBy'])->findOrFail($id);
            return view('admin.tasks.show', compact('task'));
        }

        return $this->userShow($id);
    }

    /**
     * عرض تفاصيل مهمة للمستخدم
     */
    public function userShow($id)
    {
        $user = Auth::user();
        $task = Task::findOrFail($id);

        // التحقق من أن المهمة تنتمي للمستخدم الحالي
        $canView = false;
        
        if ($user->role === 'admin') {
            if ($task->assigned_to === $user->id && $task->department === 'admin') {
                $canView = true;
            }
        } elseif ($user->role === 'marketing') {
            $marketingMember = MarketingTeam::where('admin_id', $user->id)->first();
            if ($marketingMember && $task->assigned_to === $user->id && $task->department === 'marketing') {
                $canView = true;
            }
        } elseif ($user->role === 'sales') {
            $salesMember = SalesTeam::where('admin_id', $user->id)->first();
            if ($salesMember && $task->assigned_to === $user->id && $task->department === 'sales') {
                $canView = true;
            }
        }

        if (!$canView) {
            return redirect()->route('tasks.index')
                ->with('error', 'ليس لديك صلاحية لعرض هذه المهمة');
        }

        return view('tasks.show', compact('task'));
    }

    /**
     * عرض نموذج تعديل مهمة (للإدارة)
     */
    public function edit($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('tasks.index');
        }

        $task = Task::findOrFail($id);
        
        // جلب قائمة المستخدمين الذين يمكن تعيين مهام لهم
        $marketingTeam = MarketingTeam::with('admin')->where('is_active', true)->get();
        $salesTeam = SalesTeam::with('admin')->where('is_active', true)->get();
        $admins = User::where('role', 'admin')->get();

        return view('admin.tasks.edit', compact('task', 'marketingTeam', 'salesTeam', 'admins'));
    }

    /**
     * تحديث مهمة (للإدارة)
     */
    public function update(Request $request, $id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('tasks.index');
        }

        $task = Task::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'assigned_to' => 'required|integer',
            'department' => 'required|in:admin,marketing,sales',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'due_date' => 'required|date',
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'assigned_to' => $request->assigned_to,
            'department' => $request->department,
            'priority' => $request->priority,
            'status' => $request->status,
            'due_date' => $request->due_date,
            'completed_at' => $request->status === 'completed' ? now() : null,
        ]);

        return redirect()->route('admin.tasks.show', $task->id)
            ->with('success', 'تم تحديث المهمة بنجاح');
    }

    /**
     * حذف مهمة (للإدارة)
     */
    public function destroy($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('tasks.index');
        }

        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('admin.tasks.index')
            ->with('success', 'تم حذف المهمة بنجاح');
    }

    /**
     * تحديث حالة المهمة (للإدارة)
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        if (Auth::guard('admin')->check()) {
            $task = Task::findOrFail($id);
            $task->update([
                'status' => $request->status,
                'notes' => $request->notes,
                'completed_at' => $request->status === 'completed' ? now() : null,
            ]);

            return redirect()->route('admin.tasks.show', $task->id)
                ->with('success', 'تم تحديث حالة المهمة بنجاح');
        }

        return $this->userUpdateStatus($request, $id);
    }

    /**
     * تحديث حالة المهمة للمستخدم
     */
    public function userUpdateStatus(Request $request, $id)
    {
        $user = Auth::user();
        $task = Task::findOrFail($id);

        // التحقق من أن المهمة تنتمي للمستخدم الحالي
        $canUpdate = false;
        
        if ($user->role === 'admin') {
            if ($task->assigned_to === $user->id && $task->department === 'admin') {
                $canUpdate = true;
            }
        } elseif ($user->role === 'marketing') {
            $marketingMember = MarketingTeam::where('admin_id', $user->id)->first();
            if ($marketingMember && $task->assigned_to === $user->id && $task->department === 'marketing') {
                $canUpdate = true;
            }
        } elseif ($user->role === 'sales') {
            $salesMember = SalesTeam::where('admin_id', $user->id)->first();
            if ($salesMember && $task->assigned_to === $user->id && $task->department === 'sales') {
                $canUpdate = true;
            }
        }

        if (!$canUpdate) {
            return redirect()->route('tasks.index')
                ->with('error', 'ليس لديك صلاحية لتحديث هذه المهمة');
        }

        // تحديث حالة المهمة
        $task->update([
            'status' => $request->status,
            'notes' => $request->notes,
            'completed_at' => $request->status === 'completed' ? now() : null,
        ]);

        return redirect()->route('tasks.show', $task->id)
            ->with('success', 'تم تحديث حالة المهمة بنجاح');
    }
}