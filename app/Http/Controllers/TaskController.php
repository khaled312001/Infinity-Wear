<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskBoard;
use App\Models\User;
use App\Models\Admin;
use App\Models\MarketingTeam;
use App\Models\SalesTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // جلب لوحات المهام
        $boards = TaskBoard::with(['tasks' => function($query) {
            $query->orderBy('position');
        }])->where('is_active', true)->get();
        
        // إنشاء لوحة افتراضية إذا لم توجد لوحات
        if ($boards->isEmpty()) {
            $defaultBoard = TaskBoard::create([
                'name' => 'لوحة المهام الرئيسية',
                'description' => 'لوحة المهام العامة للمشروع',
                'type' => 'general'
            ]);
            $boards = collect([$defaultBoard]);
        }
        
        // جلب المستخدمين المتاحين للتعيين
        $users = User::whereIn('user_type', ['admin', 'sales', 'marketing'])->get();
        
        // إحصائيات المهام
            $stats = [
                'total' => Task::count(),
            'pending' => Task::where('column_status', 'todo')->count(),
            'in_progress' => Task::where('column_status', 'in_progress')->count(),
            'completed' => Task::where('column_status', 'done')->count(),
            'overdue' => Task::where('due_date', '<', now())
                ->where('column_status', '!=', 'done')
                    ->count(),
            ];
            
        return view('admin.tasks.kanban', compact('boards', 'users', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // جلب لوحات المهام
        $boards = TaskBoard::where('is_active', true)->get();
        
        // جلب المستخدمين المتاحين للتعيين
        $users = User::whereIn('user_type', ['admin', 'sales', 'marketing'])->get();

        return view('admin.tasks.create', compact('boards', 'users'));
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $task = Task::with(['assignedAdmin', 'createdByAdmin'])->findOrFail($id);
        return view('admin.tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        
        // جلب لوحات المهام
        $boards = TaskBoard::where('is_active', true)->get();
        
        // جلب المستخدمين المتاحين للتعيين
        $users = User::whereIn('user_type', ['admin', 'sales', 'marketing'])->get();

        return view('admin.tasks.edit', compact('task', 'boards', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        
        // تحديد نوع الطلب (AJAX أو عادي)
        $isAjax = $request->ajax() || $request->wantsJson();

        if ($isAjax) {
            // طلب AJAX للـ Kanban
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'assigned_to' => 'required|integer',
                'assigned_to_type' => 'required|in:admin,sales,marketing',
                'priority' => 'required|in:low,medium,high,urgent',
                'due_date' => 'nullable|date',
                'estimated_hours' => 'nullable|integer|min:0',
                'labels' => 'nullable|array',
                'color' => 'nullable|string|max:7'
            ]);

            $task->update([
                'title' => $request->title,
                'description' => $request->description,
                'assigned_to' => $request->assigned_to,
                'assigned_to_type' => $request->assigned_to_type,
                'priority' => $request->priority,
                'due_date' => $request->due_date,
                'estimated_hours' => $request->estimated_hours,
                'labels' => $request->labels ?? [],
                'color' => $request->color ?? $task->color,
            ]);

            return response()->json([
                'success' => true,
                'task' => $task->load('assignedUser')
            ]);
        } else {
            // طلب عادي للنموذج القديم
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
            ]);

            return redirect()->route('admin.tasks.index')
                ->with('success', 'تم تحديث المهمة بنجاح');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        // تحديد نوع الطلب (AJAX أو عادي)
        $isAjax = request()->ajax() || request()->wantsJson();
        
        if ($isAjax) {
            return response()->json(['success' => true]);
        } else {
            return redirect()->route('admin.tasks.index')
                ->with('success', 'تم حذف المهمة بنجاح');
        }
    }

    /**
     * تحديث موضع المهمة (للسحب والإفلات)
     */
    public function updatePosition(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'column_status' => 'required|in:todo,in_progress,review,done',
            'position' => 'required|integer|min:0',
            'board_id' => 'nullable|exists:task_boards,id'
        ]);

        $task = Task::findOrFail($request->task_id);
        
        // تحديث موضع المهمة
        $task->update([
            'column_status' => $request->column_status,
            'position' => $request->position,
            'board_id' => $request->board_id ?? $task->board_id,
            'started_at' => $request->column_status === 'in_progress' && !$task->started_at ? now() : $task->started_at,
            'completed_at' => $request->column_status === 'done' ? now() : null,
        ]);

        // إعادة ترتيب المهام الأخرى في نفس العمود
        $this->reorderTasksInColumn($request->board_id ?? $task->board_id, $request->column_status, $request->position, $task->id);

        return response()->json(['success' => true]);
    }

    /**
     * إعادة ترتيب المهام في العمود
     */
    private function reorderTasksInColumn($boardId, $columnStatus, $newPosition, $excludeTaskId)
    {
        Task::where('board_id', $boardId)
            ->where('column_status', $columnStatus)
            ->where('id', '!=', $excludeTaskId)
            ->where('position', '>=', $newPosition)
            ->increment('position');
    }

    /**
     * إنشاء مهمة جديدة
     */
    public function store(Request $request)
    {
        // تحديد نوع الطلب (AJAX أو عادي)
        $isAjax = $request->ajax() || $request->wantsJson();
        
        if ($isAjax) {
            // طلب AJAX للـ Kanban
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'board_id' => 'required|exists:task_boards,id',
                'assigned_to' => 'required|integer',
                'assigned_to_type' => 'required|in:admin,sales,marketing',
                'priority' => 'required|in:low,medium,high,urgent',
                'due_date' => 'nullable|date|after_or_equal:today',
                'estimated_hours' => 'nullable|integer|min:0',
                'labels' => 'nullable|array',
                'color' => 'nullable|string|max:7'
            ]);

            // الحصول على آخر موضع في العمود
            $lastPosition = Task::where('board_id', $request->board_id)
                ->where('column_status', 'todo')
                ->max('position') ?? 0;

            $task = Task::create([
                'title' => $request->title,
                'description' => $request->description,
                'board_id' => $request->board_id,
                'assigned_to' => $request->assigned_to,
                'assigned_to_type' => $request->assigned_to_type,
                'priority' => $request->priority,
                'due_date' => $request->due_date,
                'estimated_hours' => $request->estimated_hours,
                'labels' => $request->labels ?? [],
                'color' => $request->color ?? '#007bff',
                'column_status' => 'todo',
                'position' => $lastPosition + 1,
                'status' => 'pending',
                'created_by' => Auth::guard('admin')->id(),
            ]);

            return response()->json([
                'success' => true,
                'task' => $task->load('assignedUser')
            ]);
        } else {
            // طلب عادي للنموذج القديم
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
    }

    /**
     * إضافة تعليق للمهمة
     */
    public function addComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:1000'
        ]);

        $task = Task::findOrFail($id);
        $user = Auth::guard('admin')->user();
        
        $task->addComment($request->comment, $user->id, $user->name);

        return response()->json(['success' => true]);
    }

    /**
     * إضافة عنصر للقائمة المرجعية
     */
    public function addChecklistItem(Request $request, $id)
    {
        $request->validate([
            'text' => 'required|string|max:255'
        ]);

        $task = Task::findOrFail($id);
        $task->addChecklistItem($request->text);

        return response()->json(['success' => true]);
    }

    /**
     * تحديث عنصر في القائمة المرجعية
     */
    public function updateChecklistItem(Request $request, $id)
    {
        $request->validate([
            'item_id' => 'required|string',
            'completed' => 'required|boolean'
        ]);

        $task = Task::findOrFail($id);
        $task->updateChecklistItem($request->item_id, $request->completed);

        return response()->json(['success' => true]);
    }

    /**
     * إضافة تتبع وقت
     */
    public function addTimeLog(Request $request, $id)
    {
        $request->validate([
            'minutes' => 'required|integer|min:1',
            'description' => 'nullable|string|max:255'
        ]);

        $task = Task::findOrFail($id);
        $task->addTimeLog($request->minutes, $request->description);

        return response()->json(['success' => true]);
    }

    /**
     * إنشاء لوحة مهام جديدة
     */
    public function createBoard(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:marketing,sales,general'
        ]);

        $board = TaskBoard::create([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'sort_order' => TaskBoard::max('sort_order') + 1
        ]);

        return response()->json([
            'success' => true,
            'board' => $board
        ]);
    }
}