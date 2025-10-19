<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TaskBoard;
use App\Models\TaskColumn;
use App\Models\TaskCard;
use App\Models\TaskComment;
use App\Models\TaskAttachment;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TaskManagementController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * عرض لوحة المهام الرئيسية
     */
    public function index()
    {
        $boards = TaskBoard::with(['columns.tasks' => function($query) {
            $query->where('is_archived', false)->orderBy('sort_order');
        }])
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->get();

        // إنشاء لوحة افتراضية إذا لم توجد لوحات
        if ($boards->isEmpty()) {
            $defaultBoard = TaskBoard::createWithDefaultColumns([
                'name' => 'لوحة المهام الرئيسية',
                'description' => 'لوحة المهام العامة للمشروع',
                'type' => 'general',
                'created_by' => Auth::id(),
                'color' => '#007bff',
                'icon' => 'fas fa-tasks'
            ]);
            $boards = collect([$defaultBoard]);
        }

        // جلب المستخدمين المتاحين للتعيين
        $users = $this->getAvailableUsers();

        // إحصائيات المهام
        $stats = $this->getTaskStats();

        return view('admin.tasks.index', compact('boards', 'users', 'stats'))
            ->with('availableUsers', $users)
            ->with('taskStats', $stats);
    }

    /**
     * إنشاء لوحة جديدة
     */
    public function createBoard(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'type' => 'required|in:general,marketing,sales,project,department',
            'color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'icon' => 'nullable|string|max:50',
            'team_type' => 'nullable|in:admin,marketing,sales',
            'team_id' => 'nullable|integer'
        ]);

        $board = TaskBoard::createWithDefaultColumns([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'created_by' => Auth::id(),
            'color' => $request->color ?? '#007bff',
            'icon' => $request->icon ?? 'fas fa-tasks',
            'team_type' => $request->team_type,
            'team_id' => $request->team_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم إنشاء اللوحة بنجاح',
            'board' => $board->load('columns')
        ]);
    }

    /**
     * إنشاء مهمة جديدة
     */
    public function createTask(Request $request)
    {
        try {
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
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors for AJAX requests
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'يرجى التحقق من البيانات المدخلة',
                    'errors' => $e->errors()
                ], 422);
            }
            
            // Re-throw for regular requests to show validation errors
            throw $e;
        }

        try {
            // التحقق من تسجيل الدخول
            $adminId = Auth::guard('admin')->id();
            if (!$adminId) {
                throw new \Exception('المستخدم غير مسجل دخول');
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
                'created_by' => $adminId,
                'created_by_type' => 'admin',
                'sort_order' => $sortOrder,
                'labels' => $request->labels ?? [],
                'tags' => $request->tags ?? [],
                'estimated_hours' => $request->estimated_hours,
                'color' => $request->color
            ]);

            return response()->json([
                'success' => true,
                'message' => 'تم إنشاء المهمة بنجاح',
                'task' => $task->load(['assignedAdmin', 'createdByAdmin'])
            ]);
        } catch (\Exception $e) {
            Log::error('Task creation error: ' . $e->getMessage());
            Log::error('Task creation error file: ' . $e->getFile() . ':' . $e->getLine());
            Log::error('Task creation error trace: ' . $e->getTraceAsString());
            Log::error('Task creation data: ' . json_encode($request->all()));
            
            // Handle errors for AJAX requests
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'حدث خطأ أثناء إنشاء المهمة. يرجى المحاولة مرة أخرى.',
                    'error' => 'database_error',
                    'debug' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }
            
            // Re-throw for regular requests
            throw $e;
        }
    }

    /**
     * تحديث مهمة
     */
    public function updateTask(Request $request, TaskCard $task)
    {
        // التحقق من الصلاحيات
        $user = Auth::guard('admin')->user();
        $canEdit = $this->canEditTask($user, $task);
        
        if (!$canEdit) {
            return response()->json([
                'success' => false,
                'message' => 'ليس لديك صلاحية لتعديل هذه المهمة'
            ], 403);
        }

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
            'color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'progress_percentage' => 'nullable|integer|min:0|max:100',
            'is_urgent' => 'nullable|boolean',
            'board_id' => 'sometimes|exists:task_boards,id',
            'column_id' => 'sometimes|exists:task_columns,id'
        ]);

        $updateData = $request->only([
            'title', 'description', 'priority', 'status', 'due_date',
            'assigned_to', 'assigned_to_type', 'labels', 'tags',
            'estimated_hours', 'color', 'progress_percentage', 'is_urgent'
        ]);

        // إذا تم تغيير اللوحة أو العمود
        if ($request->has('board_id') || $request->has('column_id')) {
            $updateData['board_id'] = $request->board_id;
            $updateData['column_id'] = $request->column_id;
        }

        $task->update($updateData);

        // إذا تم تحديث الحالة إلى مكتملة
        if ($request->status === 'completed' && !$task->completed_at) {
            $task->update([
                'completed_at' => now(),
                'progress_percentage' => 100
            ]);
        }

        // إرسال إشعار للمستخدم المكلف
        if ($task->assigned_to && $task->assigned_to_type) {
            $this->notifyAssignedUser($task);
        }

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث المهمة بنجاح',
            'task' => $task->load(['assignedAdmin', 'createdByAdmin'])
        ]);
    }

    /**
     * حذف مهمة
     */
    public function deleteTask(TaskCard $task)
    {
        // التحقق من الصلاحيات
        $user = Auth::guard('admin')->user();
        $canDelete = $this->canDeleteTask($user, $task);
        
        if (!$canDelete) {
            return response()->json([
                'success' => false,
                'message' => 'ليس لديك صلاحية لحذف هذه المهمة'
            ], 403);
        }

        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف المهمة بنجاح'
        ]);
    }

    /**
     * نقل مهمة إلى عمود آخر
     */
    public function moveTask(Request $request, TaskCard $task)
    {
        // التحقق من الصلاحيات
        $user = Auth::guard('admin')->user();
        $canMove = $this->canMoveTask($user, $task);
        
        if (!$canMove) {
            return response()->json([
                'success' => false,
                'message' => 'ليس لديك صلاحية لنقل هذه المهمة'
            ], 403);
        }

        $request->validate([
            'column_id' => 'required|exists:task_columns,id',
            'position' => 'nullable|integer|min:1'
        ]);

        $targetColumn = TaskColumn::findOrFail($request->column_id);
        $newPosition = $request->position ?? ($targetColumn->active_tasks_count + 1);

        $task->moveToColumn($targetColumn, $newPosition);

        // إرسال إشعار للمستخدم المكلف
        if ($task->assigned_to && $task->assigned_to_type) {
            $this->notifyAssignedUser($task);
        }

        return response()->json([
            'success' => true,
            'message' => 'تم نقل المهمة بنجاح'
        ]);
    }

    /**
     * إعادة ترتيب المهام في العمود
     */
    public function reorderTasks(Request $request, TaskColumn $column)
    {
        $request->validate([
            'task_ids' => 'required|array',
            'task_ids.*' => 'integer|exists:task_cards,id'
        ]);

        $column->reorderTasks($request->task_ids);

        return response()->json([
            'success' => true,
            'message' => 'تم إعادة ترتيب المهام بنجاح'
        ]);
    }

    /**
     * إضافة تعليق
     */
    public function addComment(Request $request, TaskCard $task)
    {
        $request->validate([
            'comment' => 'required|string|max:2000',
            'is_internal' => 'boolean'
        ]);

        $task->addComment(
            $request->comment,
            Auth::id(),
            Auth::guard('admin')->user()->name ?? 'مدير',
            'admin'
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
            'uploaded_by_type' => 'admin',
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
        $request->validate([
            'minutes' => 'required|integer|min:1',
            'description' => 'nullable|string|max:500'
        ]);

        $task->addTimeLog(
            $request->minutes,
            $request->description ?? '',
            Auth::id(),
            Auth::guard('admin')->user()->name ?? 'مدير'
        );

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة تتبع الوقت بنجاح'
        ]);
    }

    /**
     * أرشفة/إلغاء أرشفة مهمة
     */
    public function toggleArchive(TaskCard $task)
    {
        if ($task->is_archived) {
            $task->unarchive();
            $message = 'تم إلغاء أرشفة المهمة';
        } else {
            $task->archive();
            $message = 'تم أرشفة المهمة';
        }

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    /**
     * جلب المستخدمين المتاحين للتعيين
     */
    private function getAvailableUsers()
    {
        return [
            'admins' => \App\Models\User::select('id', 'name', 'email', 'user_type')
                ->where('user_type', 'admin')
                ->where('is_active', 1)
                ->get()
                ->map(function($user) {
                    return (object)[
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'user_type' => 'admin'
                    ];
                }),
            'marketing' => \App\Models\User::select('id', 'name', 'email', 'user_type')
                ->where('user_type', 'marketing')
                ->where('is_active', 1)
                ->get()
                ->map(function($user) {
                    return (object)[
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'user_type' => 'marketing'
                    ];
                }),
            'sales' => \App\Models\User::select('id', 'name', 'email', 'user_type')
                ->where('user_type', 'sales')
                ->where('is_active', 1)
                ->get()
                ->map(function($user) {
                    return (object)[
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'user_type' => 'sales'
                    ];
                }),
            'employees' => \App\Models\User::select('id', 'name', 'email', 'user_type')
                ->where('user_type', 'employee')
                ->where('is_active', 1)
                ->get()
        ];
    }

    /**
     * جلب إحصائيات المهام
     */
    private function getTaskStats()
    {
        return [
            'total_tasks' => TaskCard::where('is_archived', false)->count(),
            'completed_tasks' => TaskCard::where('status', 'completed')->where('is_archived', false)->count(),
            'in_progress_tasks' => TaskCard::where('status', 'in_progress')->where('is_archived', false)->count(),
            'pending_tasks' => TaskCard::where('status', 'pending')->where('is_archived', false)->count(),
            'overdue_tasks' => TaskCard::where('due_date', '<', now())
                ->where('status', '!=', 'completed')
                ->where('is_archived', false)
                ->count(),
            'urgent_tasks' => TaskCard::where('priority', 'urgent')
                ->where('status', '!=', 'completed')
                ->where('is_archived', false)
                ->count()
        ];
    }

    /**
     * التحقق من صلاحية تعديل المهمة
     */
    private function canEditTask($user, TaskCard $task)
    {
        // الأدمن يمكنه تعديل جميع المهام
        if ($user->user_type === 'admin' || $user->hasPermission('tasks.edit')) {
            return true;
        }

        // المستخدم يمكنه تعديل المهام المخصصة له فقط
        if ($task->assigned_to == $user->id && $task->assigned_to_type == 'admin') {
            return true;
        }

        // منشئ المهمة يمكنه تعديلها
        if ($task->created_by == $user->id && $task->created_by_type == 'admin') {
            return true;
        }

        return false;
    }

    /**
     * التحقق من صلاحية حذف المهمة
     */
    private function canDeleteTask($user, TaskCard $task)
    {
        // الأدمن يمكنه حذف جميع المهام
        if ($user->user_type === 'admin' || $user->hasPermission('tasks.delete')) {
            return true;
        }

        // منشئ المهمة يمكنه حذفها
        if ($task->created_by == $user->id && $task->created_by_type == 'admin') {
            return true;
        }

        return false;
    }

    /**
     * التحقق من صلاحية نقل المهمة
     */
    private function canMoveTask($user, TaskCard $task)
    {
        // الأدمن يمكنه نقل جميع المهام
        if ($user->user_type === 'admin' || $user->hasPermission('tasks.edit')) {
            return true;
        }

        // المستخدم المكلف يمكنه نقل المهمة
        if ($task->assigned_to == $user->id && $task->assigned_to_type == 'admin') {
            return true;
        }

        // منشئ المهمة يمكنه نقلها
        if ($task->created_by == $user->id && $task->created_by_type == 'admin') {
            return true;
        }

        return false;
    }

    /**
     * إرسال إشعار للمستخدم المكلف
     */
    private function notifyAssignedUser(TaskCard $task)
    {
        try {
            // إرسال إشعار للمستخدم المكلف
            if ($task->assigned_to && $task->assigned_to_type) {
                $assignedUser = $this->getAssignedUser($task);
                if ($assignedUser) {
                    // إرسال إشعار في قاعدة البيانات
                    $this->createTaskNotification($task, $assignedUser);
                    
                    // إرسال إشعار فوري (إذا كان متاحاً)
                    $this->sendRealTimeNotification($task, $assignedUser);
                }
            }
        } catch (\Exception $e) {
            Log::error('Error sending task notification: ' . $e->getMessage());
        }
    }

    /**
     * الحصول على المستخدم المكلف
     */
    private function getAssignedUser(TaskCard $task)
    {
        if ($task->assigned_to && $task->assigned_to_type) {
            return \App\Models\User::where('id', $task->assigned_to)
                ->where('user_type', $task->assigned_to_type)
                ->first();
        }
        return null;
    }

    /**
     * إنشاء إشعار في قاعدة البيانات
     */
    private function createTaskNotification(TaskCard $task, $assignedUser)
    {
        try {
            // إنشاء إشعار للمهمة الجديدة
            $this->notificationService->sendAdvancedNotification(
                'task',
                'مهمة جديدة',
                "تم تعيين مهمة جديدة لك: {$task->title}",
                [
                    'task_id' => $task->id,
                    'task_title' => $task->title,
                    'priority' => $task->priority,
                    'due_date' => $task->due_date,
                    'board_id' => $task->board_id,
                    'column_id' => $task->column_id
                ],
                [$assignedUser->id],
                $assignedUser->user_type
            );
        } catch (\Exception $e) {
            Log::error('Failed to create task notification: ' . $e->getMessage());
        }
    }

    /**
     * إرسال إشعار فوري
     */
    private function sendRealTimeNotification(TaskCard $task, $assignedUser)
    {
        // يمكن إضافة إرسال إشعار فوري هنا
        // WebSocket, Pusher, etc.
    }
}
