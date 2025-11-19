<?php

namespace App\Http\Controllers\Importer;

use App\Http\Controllers\Controller;
use App\Models\WorkflowOrder;
use App\Models\Importer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkflowOrderController extends Controller
{
    /**
     * عرض طلبات المستورد
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $importer = $user->importer;

        if (!$importer) {
            return redirect()->route('importers.dashboard')
                ->with('error', 'لم يتم العثور على بيانات المستورد');
        }

        $query = WorkflowOrder::where('importer_id', $importer->id)
            ->with(['customer', 'stages']);

        // فلترة حسب الحالة
        if ($request->filled('status')) {
            $query->where('overall_status', $request->status);
        }

        // البحث
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%");
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20);

        $stats = [
            'total' => WorkflowOrder::where('importer_id', $importer->id)->count(),
            'new' => WorkflowOrder::where('importer_id', $importer->id)->where('overall_status', 'new')->count(),
            'in_progress' => WorkflowOrder::where('importer_id', $importer->id)->where('overall_status', 'in_progress')->count(),
            'completed' => WorkflowOrder::where('importer_id', $importer->id)->where('overall_status', 'completed')->count(),
        ];

        return view('importer.workflow-orders.index', compact('orders', 'stats'));
    }

    /**
     * عرض تفاصيل الطلب
     */
    public function show(WorkflowOrder $workflowOrder)
    {
        $user = Auth::user();
        $importer = $user->importer;

        // التحقق من أن الطلب يخص هذا المستورد
        if ($workflowOrder->importer_id !== $importer->id) {
            return redirect()->route('importer.workflow-orders.index')
                ->with('error', 'ليس لديك صلاحية لعرض هذا الطلب');
        }

        $workflowOrder->load([
            'importer', 'customer', 'stages',
            'marketingUser', 'salesUser', 'designUser',
            'firstSampleUser', 'workApprovalUser', 'manufacturingUser',
            'shippingUser', 'receiptDeliveryUser', 'collectionUser', 'afterSalesUser'
        ]);

        return view('importer.workflow-orders.show', compact('workflowOrder'));
    }
}
