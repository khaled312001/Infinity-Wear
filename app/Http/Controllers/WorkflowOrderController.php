<?php

namespace App\Http\Controllers;

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
     * عرض صفحة تتبع الطلب للعميل
     */
    public function track(Request $request)
    {
        $orderNumber = $request->get('order_number');
        $order = null;

        if ($orderNumber) {
            $order = WorkflowOrder::where('order_number', $orderNumber)
                ->with(['importer', 'customer', 'stages'])
                ->first();
        }

        return view('workflow-orders.track', compact('order', 'orderNumber'));
    }

    /**
     * عرض تفاصيل الطلب للعميل
     */
    public function show($orderNumber)
    {
        $order = WorkflowOrder::where('order_number', $orderNumber)
            ->with(['importer', 'customer', 'stages', 'marketingUser', 'salesUser', 'designUser'])
            ->firstOrFail();

        return view('workflow-orders.show', compact('order'));
    }
}
