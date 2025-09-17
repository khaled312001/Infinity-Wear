<?php

namespace App\Http\Controllers;

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
     * عرض نموذج إنشاء طلب جديد
     */
    public function create()
    {
        $users = \App\Models\User::where('user_type', 'customer')
            ->select('id', 'name', 'email')
            ->orderBy('name')
            ->get();
            
        return view('admin.orders.create', compact('users'));
    }

    /**
     * حفظ طلب جديد
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        // إنشاء الطلب
        $order = Order::create([
            'user_id' => $validated['user_id'],
            'status' => $validated['status'],
            'notes' => $validated['notes'],
            'total_amount' => 0, // سيتم حسابها لاحقاً
        ]);

        // إضافة عناصر الطلب
        $totalAmount = 0;
        foreach ($validated['items'] as $item) {
            $order->orderItems()->create([
                'product_name' => $item['product_name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['quantity'] * $item['price'],
            ]);
            $totalAmount += $item['quantity'] * $item['price'];
        }

        // تحديث المبلغ الإجمالي
        $order->update(['total_amount' => $totalAmount]);

        return redirect()->route('admin.orders.index')
            ->with('success', 'تم إنشاء الطلب بنجاح');
    }

    /**
     * عرض نموذج تعديل الطلب
     */
    public function edit(Order $order)
    {
        $order->load(['user', 'orderItems']);
        $users = \App\Models\User::where('user_type', 'customer')
            ->select('id', 'name', 'email')
            ->orderBy('name')
            ->get();
            
        return view('admin.orders.edit', compact('order', 'users'));
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
