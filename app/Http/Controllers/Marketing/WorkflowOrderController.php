<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\WorkflowOrder;
use App\Models\WorkflowOrderStage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkflowOrderController extends Controller
{
    /**
     * عرض طلبات التسويق
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = WorkflowOrder::where('marketing_user_id', $user->id)
            ->orWhere(function($q) use ($user) {
                $q->where('marketing_status', 'pending')
                  ->whereNull('marketing_user_id');
            })
            ->with(['importer', 'customer']);

        // فلترة حسب الحالة
        if ($request->filled('status')) {
            $query->where('marketing_status', $request->status);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20);

        $stats = [
            'total' => WorkflowOrder::where('marketing_user_id', $user->id)->count(),
            'pending' => WorkflowOrder::where('marketing_user_id', $user->id)->where('marketing_status', 'pending')->count(),
            'in_progress' => WorkflowOrder::where('marketing_user_id', $user->id)->where('marketing_status', 'in_progress')->count(),
            'completed' => WorkflowOrder::where('marketing_user_id', $user->id)->where('marketing_status', 'completed')->count(),
        ];

        return view('marketing.workflow-orders.index', compact('orders', 'stats'));
    }

    /**
     * عرض تفاصيل الطلب
     */
    public function show(WorkflowOrder $workflowOrder)
    {
        $workflowOrder->load(['importer', 'customer', 'stages', 'salesUser']);

        return view('marketing.workflow-orders.show', compact('workflowOrder'));
    }

    /**
     * تحديث حالة مرحلة التسويق
     */
    public function updateStage(Request $request, WorkflowOrder $workflowOrder)
    {
        $user = Auth::user();

        // التحقق من أن المستخدم معين لهذا الطلب
        if ($workflowOrder->marketing_user_id !== $user->id && $workflowOrder->marketing_user_id !== null) {
            return redirect()->back()->with('error', 'ليس لديك صلاحية لتعديل هذا الطلب');
        }

        $request->validate([
            'status' => 'required|in:pending,in_progress,completed,rejected',
            'notes' => 'nullable|string|max:1000',
        ]);

        // تعيين المستخدم إذا لم يكن معيناً
        if (!$workflowOrder->marketing_user_id) {
            $workflowOrder->marketing_user_id = $user->id;
        }

        // تحديث حالة المرحلة
        $workflowOrder->updateStageStatus('marketing', $request->status, $user->id);

        // تحديث سجل المرحلة
        $stageRecord = WorkflowOrderStage::where('workflow_order_id', $workflowOrder->id)
            ->where('stage_name', 'marketing')
            ->first();

        if ($stageRecord) {
            $stageRecord->update([
                'status' => $request->status,
                'assigned_user_id' => $user->id,
                'notes' => $request->notes ?? $stageRecord->notes,
                'started_at' => $request->status === 'in_progress' && !$stageRecord->started_at ? now() : $stageRecord->started_at,
                'completed_at' => $request->status === 'completed' && !$stageRecord->completed_at ? now() : $stageRecord->completed_at,
            ]);
        } else {
            WorkflowOrderStage::create([
                'workflow_order_id' => $workflowOrder->id,
                'stage_name' => 'marketing',
                'status' => $request->status,
                'assigned_user_id' => $user->id,
                'notes' => $request->notes,
                'started_at' => $request->status === 'in_progress' ? now() : null,
                'completed_at' => $request->status === 'completed' ? now() : null,
            ]);
        }

        // إذا تم إكمال مرحلة التسويق، نقل الطلب لمرحلة المبيعات
        if ($request->status === 'completed') {
            $workflowOrder->update(['sales_status' => 'pending']);
        }

        return redirect()->back()->with('success', 'تم تحديث حالة المرحلة بنجاح');
    }
}
