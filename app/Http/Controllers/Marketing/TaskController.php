<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\TaskCard;
use App\Models\TaskColumn;
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
        // جلب المهام المخصصة لفريق التسويق
        $tasks = TaskCard::where('department', 'marketing')
            ->where('is_archived', false)
            ->with(['column', 'board'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('marketing.tasks.index', compact('tasks'));
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

        $task->addComment(
            $request->comment,
            Auth::id(),
            Auth::user()->name ?? 'فريق التسويق',
            'marketing'
        );

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة التعليق بنجاح'
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