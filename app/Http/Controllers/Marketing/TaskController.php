<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\TaskCard;
use App\Models\TaskColumn;
use App\Models\TaskBoard;
use App\Models\MarketingTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    /**
     * عرض المهام لفريق التسويق
     */
    public function index()
    {
        $currentUser = Auth::user();
        
        // جلب المهام المخصصة للمستخدم الحالي فقط
        $tasks = TaskCard::where('is_archived', false)
            ->where(function($query) use ($currentUser) {
                $query->where('assigned_to', $currentUser->id)
                      ->where('assigned_to_type', 'marketing');
            })
            ->with(['column', 'board', 'assignedUser'])
            ->orderBy('created_at', 'desc')
            ->get();

        // جلب لوحات المهام مع المهام
        $boards = TaskBoard::where('is_active', true)
            ->where(function($query) {
                $query->where('type', 'marketing')
                      ->orWhere('type', 'general');
            })
            ->with(['columns' => function($query) use ($currentUser) {
                $query->orderBy('sort_order')
                      ->with(['tasks' => function($taskQuery) use ($currentUser) {
                          $taskQuery->where('is_archived', false)
                                   ->where('assigned_to', $currentUser->id)
                                   ->where('assigned_to_type', 'marketing')
                                   ->with('assignedUser')
                                   ->orderBy('sort_order');
                      }]);
            }])
            ->orderBy('sort_order')
            ->get();

        // حساب الإحصائيات
        $stats = [
            'total_tasks' => $tasks->count(),
            'completed_tasks' => $tasks->where('status', 'completed')->count(),
            'pending_tasks' => $tasks->where('status', 'pending')->count(),
            'in_progress_tasks' => $tasks->where('status', 'in_progress')->count(),
            'overdue_tasks' => $tasks->where('due_date', '<', now())->where('status', '!=', 'completed')->count(),
            'urgent_tasks' => $tasks->where('priority', 'high')->where('status', '!=', 'completed')->count(),
        ];

        return view('marketing.tasks.index', compact('tasks', 'stats', 'boards'));
    }

    /**
     * عرض مهمة محددة
     */
    public function show(TaskCard $task)
    {
        $this->authorizeTaskAccess($task);

        return view('marketing.tasks.show', compact('task'));
    }

    /**
     * نقل مهمة (الصلاحية الوحيدة المتاحة)
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

        // إنشاء تعليق جديد في جدول منفصل
        $comment = \App\Models\TaskComment::create([
            'task_id' => $task->id,
            'user_id' => Auth::id(),
            'user_type' => 'marketing',
            'user_name' => Auth::user()->name ?? 'فريق التسويق',
            'comment' => $request->comment,
            'is_internal' => $request->boolean('is_internal', false)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة التعليق بنجاح',
            'comment' => [
                'id' => $comment->id,
                'comment' => $comment->comment,
                'author_name' => $comment->user_name,
                'author_type' => $comment->user_type,
                'created_at' => $comment->created_at->format('Y-m-d H:i:s'),
                'is_internal' => $comment->is_internal
            ]
        ]);
    }

    /**
     * جلب تعليقات المهمة
     */
    public function getComments(TaskCard $task)
    {
        $this->authorizeTaskAccess($task);

        $comments = $task->taskComments()
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'comment' => $comment->comment,
                    'author_name' => $comment->user_name,
                    'author_type' => $comment->user_type,
                    'created_at' => $comment->created_at->format('Y-m-d H:i:s'),
                    'is_internal' => $comment->is_internal ?? false
                ];
            });

        return response()->json([
            'success' => true,
            'comments' => $comments
        ]);
    }

    /**
     * التحقق من صلاحية الوصول للمهمة
     */
    private function authorizeTaskAccess(TaskCard $task)
    {
        // التحقق من أن المهمة مرتبطة بالتسويق
        if ($task->department !== 'marketing') {
            abort(403, 'ليس لديك صلاحية للوصول لهذه المهمة');
        }

        // يمكن للفريق الوصول للمهام المخصصة له أو المهام العامة
        $canAccess = $task->assigned_to === Auth::id() && $task->assigned_to_type === 'marketing'
                  || $task->created_by === Auth::id() && $task->created_by_type === 'marketing'
                  || $task->board->board_type === 'general'
                  || $task->board->board_type === 'marketing';

        if (!$canAccess) {
            abort(403, 'ليس لديك صلاحية للوصول لهذه المهمة');
        }
    }
}