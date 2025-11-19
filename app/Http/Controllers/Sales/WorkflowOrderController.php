<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\WorkflowOrder;
use App\Models\WorkflowOrderStage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkflowOrderController extends Controller
{
    /**
     * عرض طلبات المبيعات
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = WorkflowOrder::where('sales_user_id', $user->id)
            ->orWhere(function($q) use ($user) {
                $q->where('sales_status', 'pending')
                  ->where('marketing_status', 'completed')
                  ->whereNull('sales_user_id');
            })
            ->with(['importer', 'customer', 'marketingUser']);

        // فلترة حسب الحالة
        if ($request->filled('status')) {
            $query->where('sales_status', $request->status);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20);

        $stats = [
            'total' => WorkflowOrder::where('sales_user_id', $user->id)->count(),
            'pending' => WorkflowOrder::where('sales_user_id', $user->id)->where('sales_status', 'pending')->count(),
            'in_progress' => WorkflowOrder::where('sales_user_id', $user->id)->where('sales_status', 'in_progress')->count(),
            'completed' => WorkflowOrder::where('sales_user_id', $user->id)->where('sales_status', 'completed')->count(),
        ];

        return view('sales.workflow-orders.index', compact('orders', 'stats'));
    }

    /**
     * عرض تفاصيل الطلب
     */
    public function show(WorkflowOrder $workflowOrder)
    {
        $workflowOrder->load(['importer', 'customer', 'stages', 'marketingUser', 'designUser']);

        return view('sales.workflow-orders.show', compact('workflowOrder'));
    }

    /**
     * تحديث حالة مرحلة المبيعات
     */
    public function updateStage(Request $request, WorkflowOrder $workflowOrder)
    {
        $user = Auth::user();

        // التحقق من أن مرحلة التسويق مكتملة
        if ($workflowOrder->marketing_status !== 'completed') {
            return redirect()->back()->with('error', 'يجب إكمال مرحلة التسويق أولاً');
        }

        // التحقق من أن المستخدم معين لهذا الطلب
        if ($workflowOrder->sales_user_id !== $user->id && $workflowOrder->sales_user_id !== null) {
            return redirect()->back()->with('error', 'ليس لديك صلاحية لتعديل هذا الطلب');
        }

        $request->validate([
            'status' => 'required|in:pending,in_progress,completed,rejected',
            'notes' => 'nullable|string|max:1000',
        ]);

        // تعيين المستخدم إذا لم يكن معيناً
        if (!$workflowOrder->sales_user_id) {
            $workflowOrder->sales_user_id = $user->id;
        }

        // تحديث حالة المرحلة
        $workflowOrder->updateStageStatus('sales', $request->status, $user->id);

        // تحديث سجل المرحلة
        $stageRecord = WorkflowOrderStage::where('workflow_order_id', $workflowOrder->id)
            ->where('stage_name', 'sales')
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
                'stage_name' => 'sales',
                'status' => $request->status,
                'assigned_user_id' => $user->id,
                'notes' => $request->notes,
                'started_at' => $request->status === 'in_progress' ? now() : null,
                'completed_at' => $request->status === 'completed' ? now() : null,
            ]);
        }

        // إذا تم إكمال مرحلة المبيعات، نقل الطلب لمرحلة التصميم
        if ($request->status === 'completed') {
            $workflowOrder->update(['design_status' => 'pending']);
        }

        return redirect()->back()->with('success', 'تم تحديث حالة المرحلة بنجاح');
    }
}
