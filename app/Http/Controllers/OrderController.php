<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * عرض قائمة الطلبات
     */
    public function index()
    {
        $orders = Order::with(['user', 'orderItems.product'])
            ->latest()
            ->paginate(15);
            
        return view('admin.orders.index', compact('orders'));
    }
    
    /**
     * عرض تفاصيل طلب محدد
     */
    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product']);
        return view('admin.orders.show', compact('order'));
    }
    
    /**
     * تحديث حالة الطلب
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'notes' => 'nullable|string',
        ]);
        
        $order->update($validated);
        
        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'تم تحديث حالة الطلب بنجاح');
    }
    
    /**
     * حذف طلب
     */
    public function destroy(Order $order)
    {
        $order->delete();
        
        return redirect()->route('admin.orders.index')
            ->with('success', 'تم حذف الطلب بنجاح');
    }
}
