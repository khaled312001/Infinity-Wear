<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkflowOrder;
use App\Models\WorkflowOrderStage;
use App\Models\User;
use App\Models\Importer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WorkflowOrderController extends Controller
{
    /**
     * عرض قائمة جميع الطلبات
     */
    public function index(Request $request)
    {
        $query = WorkflowOrder::with(['importer', 'customer']);

        // البحث
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        // فلترة حسب الحالة
        if ($request->filled('status')) {
            $query->where('overall_status', $request->status);
        }

        // فلترة حسب المرحلة
        if ($request->filled('stage')) {
            $stageField = $request->stage . '_status';
            $query->where($stageField, 'in_progress');
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20);

        // إحصائيات
        $stats = [
            'total' => WorkflowOrder::count(),
            'new' => WorkflowOrder::where('overall_status', 'new')->count(),
            'in_progress' => WorkflowOrder::where('overall_status', 'in_progress')->count(),
            'completed' => WorkflowOrder::where('overall_status', 'completed')->count(),
            'cancelled' => WorkflowOrder::where('overall_status', 'cancelled')->count(),
        ];

        return view('admin.workflow-orders.index', compact('orders', 'stats'));
    }

    /**
     * عرض تفاصيل الطلب
     */
    public function show(WorkflowOrder $workflowOrder)
    {
        $workflowOrder->load([
            'importer', 'customer', 'stages',
            'marketingUser', 'salesUser', 'designUser',
            'firstSampleUser', 'workApprovalUser', 'manufacturingUser',
            'shippingUser', 'receiptDeliveryUser', 'collectionUser', 'afterSalesUser'
        ]);

        // الحصول على المستخدمين المتاحين لكل مرحلة
        $marketingUsers = User::where('user_type', 'marketing')->get();
        $salesUsers = User::where('user_type', 'sales')->get();
        $designUsers = User::where('user_type', 'employee')->orWhere('user_type', 'admin')->get();
        $importers = Importer::all();

        return view('admin.workflow-orders.show', compact('workflowOrder', 'marketingUsers', 'salesUsers', 'designUsers', 'importers'));
    }

    /**
     * إنشاء طلب جديد
     */
    public function create()
    {
        $importers = Importer::all();
        $customers = User::where('user_type', 'importer')->get();
        $marketingUsers = User::where('user_type', 'marketing')->get();

        return view('admin.workflow-orders.create', compact('importers', 'customers', 'marketingUsers'));
    }

    /**
     * حفظ الطلب الجديد
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'nullable|string',
            'importer_id' => 'nullable|exists:importers,id',
            'requirements' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'estimated_cost' => 'nullable|numeric|min:0',
            'marketing_user_id' => 'nullable|exists:users,id',
        ]);

        $order = WorkflowOrder::create([
            'order_number' => WorkflowOrder::generateOrderNumber(),
            'importer_id' => $request->importer_id,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address,
            'requirements' => $request->requirements,
            'quantity' => $request->quantity,
            'estimated_cost' => $request->estimated_cost,
            'marketing_user_id' => $request->marketing_user_id,
            'marketing_status' => $request->marketing_user_id ? 'pending' : 'pending',
            'overall_status' => 'new',
        ]);

        // إنشاء سجل المرحلة الأولى (التسويق)
        if ($request->marketing_user_id) {
            WorkflowOrderStage::create([
                'workflow_order_id' => $order->id,
                'stage_name' => 'marketing',
                'status' => 'pending',
                'assigned_user_id' => $request->marketing_user_id,
            ]);
        }

        return redirect()->route('admin.workflow-orders.show', $order)
            ->with('success', 'تم إنشاء الطلب بنجاح');
    }

    /**
     * تحديث حالة المرحلة
     */
    public function updateStage(Request $request, WorkflowOrder $workflowOrder)
    {
        $request->validate([
            'stage' => 'required|in:marketing,sales,design,first_sample,work_approval,manufacturing,shipping,receipt_delivery,collection,after_sales',
            'status' => 'required|in:pending,in_progress,completed,rejected,approved',
            'user_id' => 'nullable|exists:users,id',
            'notes' => 'nullable|string|max:1000',
        ]);

        $stage = $request->stage;
        $status = $request->status;
        $userId = $request->user_id;

        // تحديث حالة المرحلة في الطلب
        $workflowOrder->updateStageStatus($stage, $status, $userId);

        // تحديث أو إنشاء سجل المرحلة
        $stageRecord = WorkflowOrderStage::where('workflow_order_id', $workflowOrder->id)
            ->where('stage_name', $stage)
            ->first();

        if ($stageRecord) {
            $stageRecord->update([
                'status' => $status,
                'assigned_user_id' => $userId ?? $stageRecord->assigned_user_id,
                'notes' => $request->notes ?? $stageRecord->notes,
                'started_at' => $status === 'in_progress' && !$stageRecord->started_at ? now() : $stageRecord->started_at,
                'completed_at' => ($status === 'completed' || $status === 'approved') && !$stageRecord->completed_at ? now() : $stageRecord->completed_at,
            ]);
        } else {
            WorkflowOrderStage::create([
                'workflow_order_id' => $workflowOrder->id,
                'stage_name' => $stage,
                'status' => $status,
                'assigned_user_id' => $userId,
                'notes' => $request->notes,
                'started_at' => $status === 'in_progress' ? now() : null,
                'completed_at' => ($status === 'completed' || $status === 'approved') ? now() : null,
            ]);
        }

        // إذا تم إكمال المرحلة، نقل الطلب للمرحلة التالية
        if ($status === 'completed' || $status === 'approved') {
            $this->moveToNextStage($workflowOrder, $stage);
        }

        return redirect()->back()->with('success', 'تم تحديث حالة المرحلة بنجاح');
    }

    /**
     * نقل الطلب للمرحلة التالية
     */
    private function moveToNextStage(WorkflowOrder $order, string $currentStage)
    {
        $stageOrder = [
            'marketing' => 'sales',
            'sales' => 'design',
            'design' => 'first_sample',
            'first_sample' => 'work_approval',
            'work_approval' => 'manufacturing',
            'manufacturing' => 'shipping',
            'shipping' => 'receipt_delivery',
            'receipt_delivery' => 'collection',
            'collection' => 'after_sales',
        ];

        if (isset($stageOrder[$currentStage])) {
            $nextStage = $stageOrder[$currentStage];
            $statusField = $nextStage . '_status';
            
            // إذا كانت المرحلة التالية في حالة pending، لا تغيرها
            // فقط إذا كانت المرحلة الحالية مكتملة
            if ($order->$statusField === 'pending') {
                // يمكن إضافة منطق تلقائي هنا إذا لزم الأمر
            }
        }
    }

    /**
     * تحديث معلومات الطلب
     */
    public function update(Request $request, WorkflowOrder $workflowOrder)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'nullable|string',
            'requirements' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'estimated_cost' => 'nullable|numeric|min:0',
            'final_cost' => 'nullable|numeric|min:0',
            'expected_delivery_date' => 'nullable|date',
            'tracking_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $workflowOrder->update($request->only([
            'customer_name', 'customer_email', 'customer_phone', 'customer_address',
            'requirements', 'quantity', 'estimated_cost', 'final_cost',
            'expected_delivery_date', 'tracking_number', 'notes'
        ]));

        return redirect()->back()->with('success', 'تم تحديث الطلب بنجاح');
    }

    /**
     * حذف الطلب
     */
    public function destroy(WorkflowOrder $workflowOrder)
    {
        $workflowOrder->delete();
        return redirect()->route('admin.workflow-orders.index')
            ->with('success', 'تم حذف الطلب بنجاح');
    }
}
