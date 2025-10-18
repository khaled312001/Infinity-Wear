<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\TaskBoard;
use App\Models\TaskColumn;
use App\Models\TaskCard;
use App\Models\TaskComment;
use App\Models\TaskAttachment;
use App\Models\Admin;
use App\Models\MarketingTeam;
use App\Models\SalesTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TaskController extends Controller
{
    /**
     * عرض لوحة المهام لفريق التسويق
     */
    public function index()
    {
        try {
            $boards = TaskBoard::with(['columns.tasks' => function($query) {
                $query->where('is_archived', false)->orderBy('sort_order');
            }])
            ->where('is_active', true)
            ->where(function($query) {
                $query->where('board_type', 'marketing')
                      ->orWhere('board_type', 'general')
                      ->orWhere(function($q) {
                          $q->where('team_type', 'marketing')
                            ->where('team_id', Auth::id());
                      });
            })
            ->orderBy('sort_order')
            ->get();

            // جلب المستخدمين المتاحين للتعيين
            $users = $this->getAvailableUsers();

            // إحصائيات المهام
            $stats = $this->getTaskStats();

            return view('marketing.tasks.index', compact('boards', 'users', 'stats'));
            
        } catch (\Exception $e) {
            \Log::error('Marketing tasks index error: ' . $e->getMessage());
            
            // Return empty data if database is unavailable
            $boards = collect();
            $users = collect();
            $stats = [
                'total_tasks' => 0,
                'completed_tasks' => 0,
                'in_progress_tasks' => 0,
                'pending_tasks' => 0,
                'overdue_tasks' => 0,
                'urgent_tasks' => 0
            ];
            
            return view('marketing.tasks.index', compact('boards', 'users', 'stats'))
                ->with('error', 'لا يمكن تحميل المهام حالياً. يرجى المحاولة لاحقاً.');
        }
    }

    /**
     * إنشاء مهمة جديدة
     */
    public function createTask(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'board_id' => 'required|exists:task_boards,id',
            'column_id' => 'required|exists:task_columns,id',
            'priority' => 'required|in:low,medium,high,urgent,critical',
            'due_date' => 'nullable|date|after_or_equal:today',
            'assigned_to' => 'nullable|integer',
            'assigned_to_type' => 'nullable|in:admin,marketing,sales',
            'labels' => 'nullable|array',
            'tags' => 'nullable|array',
            'estimated_hours' => 'nullable|numeric|min:0',
            'color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/'
        ]);

        // التحقق من تسجيل الدخول
        $userId = Auth::id();
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'المستخدم غير مسجل دخول',
                'error' => 'unauthenticated'
            ], 401);
        }

        $column = TaskColumn::findOrFail($request->column_id);
        $sortOrder = $column->active_tasks_count + 1;

        $task = TaskCard::create([
            'title' => $request->title,
            'description' => $request->description,
            'board_id' => $request->board_id,
            'column_id' => $request->column_id,
            'priority' => $request->priority,
            'due_date' => $request->due_date,
            'assigned_to' => $request->assigned_to,
            'assigned_to_type' => $request->assigned_to_type,
            'created_by' => $userId,
            'created_by_type' => 'marketing',
            'sort_order' => $sortOrder,
            'labels' => $request->labels ?? [],
            'tags' => $request->tags ?? [],
            'estimated_hours' => $request->estimated_hours,
            'color' => $request->color
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم إنشاء المهمة بنجاح',
            'task' => $task->load(['assignedMarketing', 'createdByMarketing'])
        ]);
    }

    /**
     * تحديث مهمة
     */
    public function updateTask(Request $request, TaskCard $task)
    {
        // التحقق من الصلاحية
        $this->authorizeTaskAccess($task);

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'priority' => 'sometimes|in:low,medium,high,urgent,critical',
            'status' => 'sometimes|in:pending,in_progress,completed,cancelled,on_hold',
            'due_date' => 'nullable|date',
            'assigned_to' => 'nullable|integer',
            'assigned_to_type' => 'nullable|in:admin,marketing,sales',
            'labels' => 'nullable|array',
            'tags' => 'nullable|array',
            'estimated_hours' => 'nullable|numeric|min:0',
            'color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/'
        ]);

        $task->update($request->only([
            'title', 'description', 'priority', 'status', 'due_date',
            'assigned_to', 'assigned_to_type', 'labels', 'tags',
            'estimated_hours', 'color'
        ]));

        // إذا تم تحديث الحالة إلى مكتملة
        if ($request->status === 'completed' && !$task->completed_at) {
            $task->update([
                'completed_at' => now(),
                'progress_percentage' => 100
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث المهمة بنجاح',
            'task' => $task->load(['assignedMarketing', 'createdByMarketing'])
        ]);
    }

    /**
     * نقل مهمة إلى عمود آخر
     */
    public function moveTask(Request $request, TaskCard $task)
    {
        $this->authorizeTaskAccess($task);

        $request->validate([
            'column_id' => 'required|exists:task_columns,id',
            'position' => 'nullable|integer|min:1'
        ]);

        $targetColumn = TaskColumn::findOrFail($request->column_id);
        $newPosition = $request->position ?? ($targetColumn->active_tasks_count + 1);

        $task->moveToColumn($targetColumn, $newPosition);

        return response()->json([
            'success' => true,
            'message' => 'تم نقل المهمة بنجاح'
        ]);
    }

    /**
     * إضافة تعليق
     */
    public function addComment(Request $request, TaskCard $task)
    {
        $this->authorizeTaskAccess($task);

        $request->validate([
            'comment' => 'required|string|max:2000',
            'is_internal' => 'boolean'
        ]);

        $task->addComment(
            $request->comment,
            Auth::id(),
            Auth::user()->name ?? 'فريق التسويق',
            'marketing',
            $request->is_internal ?? false
        );

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة التعليق بنجاح'
        ]);
    }

    /**
     * إضافة مرفق
     */
    public function addAttachment(Request $request, TaskCard $task)
    {
        $this->authorizeTaskAccess($task);

        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
            'description' => 'nullable|string|max:500'
        ]);

        $file = $request->file('file');
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('task-attachments', $fileName, 'public');

        $attachment = TaskAttachment::create([
            'task_id' => $task->id,
            'file_name' => $fileName,
            'original_name' => $file->getClientOriginalName(),
            'file_path' => $filePath,
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'uploaded_by' => Auth::id(),
            'uploaded_by_type' => 'marketing',
            'description' => $request->description
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم رفع المرفق بنجاح',
            'attachment' => $attachment
        ]);
    }

    /**
     * إضافة عنصر للقائمة المرجعية
     */
    public function addChecklistItem(Request $request, TaskCard $task)
    {
        $this->authorizeTaskAccess($task);

        $request->validate([
            'text' => 'required|string|max:500'
        ]);

        $task->addChecklistItem($request->text);

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة العنصر للقائمة المرجعية'
        ]);
    }

    /**
     * تحديث عنصر في القائمة المرجعية
     */
    public function updateChecklistItem(Request $request, TaskCard $task)
    {
        $this->authorizeTaskAccess($task);

        $request->validate([
            'item_id' => 'required|string',
            'completed' => 'required|boolean'
        ]);

        $task->updateChecklistItem($request->item_id, $request->completed);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث العنصر في القائمة المرجعية'
        ]);
    }

    /**
     * إضافة تتبع وقت
     */
    public function addTimeLog(Request $request, TaskCard $task)
    {
        $this->authorizeTaskAccess($task);

        $request->validate([
            'minutes' => 'required|integer|min:1',
            'description' => 'nullable|string|max:500'
        ]);

        $task->addTimeLog(
            $request->minutes,
            $request->description ?? '',
            Auth::id(),
            Auth::user()->name ?? 'فريق التسويق'
        );

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة تتبع الوقت بنجاح'
        ]);
    }

    /**
     * التحقق من صلاحية الوصول للمهمة
     */
    private function authorizeTaskAccess(TaskCard $task)
    {
        // يمكن للفريق الوصول للمهام المخصصة له أو المهام العامة
        $canAccess = $task->assigned_to === Auth::id() && $task->assigned_to_type === 'marketing'
                  || $task->created_by === Auth::id() && $task->created_by_type === 'marketing'
                  || $task->board->board_type === 'general'
                  || $task->board->board_type === 'marketing';

        if (!$canAccess) {
            abort(403, 'ليس لديك صلاحية للوصول لهذه المهمة');
        }
    }

    /**
     * جلب المستخدمين المتاحين للتعيين
     */
    private function getAvailableUsers()
    {
        try {
            return [
                'admins' => Admin::select('id', 'name', 'email')->get(),
                'marketing' => MarketingTeam::select('id', 'name', 'email')->get(),
                'sales' => SalesTeam::select('id', 'name', 'email')->get()
            ];
        } catch (\Exception $e) {
            \Log::warning('Failed to load users for task assignment: ' . $e->getMessage());
            return [
                'admins' => collect(),
                'marketing' => collect(),
                'sales' => collect()
            ];
        }
    }

    /**
     * جلب إحصائيات المهام
     */
    private function getTaskStats()
    {
        try {
            $marketingTasks = TaskCard::where('is_archived', false)
                ->where(function($query) {
                    $query->where('assigned_to', Auth::id())
                          ->where('assigned_to_type', 'marketing')
                          ->orWhere('created_by', Auth::id())
                          ->where('created_by_type', 'marketing');
                });

            return [
                'total_tasks' => $marketingTasks->count(),
                'completed_tasks' => $marketingTasks->where('status', 'completed')->count(),
                'in_progress_tasks' => $marketingTasks->where('status', 'in_progress')->count(),
                'pending_tasks' => $marketingTasks->where('status', 'pending')->count(),
                'overdue_tasks' => $marketingTasks->where('due_date', '<', now())
                    ->where('status', '!=', 'completed')
                    ->count(),
                'urgent_tasks' => $marketingTasks->where('priority', 'urgent')
                    ->where('status', '!=', 'completed')
                    ->count()
            ];
        } catch (\Exception $e) {
            \Log::warning('Failed to load task stats: ' . $e->getMessage());
            return [
                'total_tasks' => 0,
                'completed_tasks' => 0,
                'in_progress_tasks' => 0,
                'pending_tasks' => 0,
                'overdue_tasks' => 0,
                'urgent_tasks' => 0
            ];
        }
    }
}
