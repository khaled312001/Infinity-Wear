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
     * عرض قائمة المهام للمستخدم الحالي
     */
    public function index()
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
     * عرض تفاصيل مهمة معينة
     */
    public function show($id)
    {
        $user = Auth::user();
        $task = Task::findOrFail($id);

        // التحقق من أن المهمة تنتمي للمستخدم الحالي
        $canView = false;
        
        if ($user->role === 'admin') {
            if ($task->assigned_to_type === 'admin' && $task->assigned_to === $user->id) {
                $canView = true;
            }
        } elseif ($user->role === 'marketing') {
            $marketingMember = MarketingTeam::where('admin_id', $user->id)->first();
            if ($marketingMember && $task->assigned_to_type === 'marketing' && $task->assigned_to === $marketingMember->id) {
                $canView = true;
            }
        } elseif ($user->role === 'sales') {
            $salesMember = SalesTeam::where('admin_id', $user->id)->first();
            if ($salesMember && $task->assigned_to_type === 'sales' && $task->assigned_to === $salesMember->id) {
                $canView = true;
            }
        } elseif ($user->role === 'super_admin') {
            $canView = true;
        }

        if (!$canView) {
            return redirect()->route('tasks.index')
                ->with('error', 'ليس لديك صلاحية لعرض هذه المهمة');
        }

        return view('tasks.show', compact('task'));
    }

    /**
     * تحديث حالة المهمة
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
            'notes' => 'nullable|string',
        ]);

        $user = Auth::user();
        $task = Task::findOrFail($id);

        // التحقق من أن المهمة تنتمي للمستخدم الحالي
        $canUpdate = false;
        
        if ($user->role === 'admin') {
            if ($task->assigned_to_type === 'admin' && $task->assigned_to === $user->id) {
                $canUpdate = true;
            }
        } elseif ($user->role === 'marketing') {
            $marketingMember = MarketingTeam::where('admin_id', $user->id)->first();
            if ($marketingMember && $task->assigned_to_type === 'marketing' && $task->assigned_to === $marketingMember->id) {
                $canUpdate = true;
            }
        } elseif ($user->role === 'sales') {
            $salesMember = SalesTeam::where('admin_id', $user->id)->first();
            if ($salesMember && $task->assigned_to_type === 'sales' && $task->assigned_to === $salesMember->id) {
                $canUpdate = true;
            }
        } elseif ($user->role === 'super_admin') {
            $canUpdate = true;
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
}