<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerNote;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerNotesController extends Controller
{
    /**
     * عرض قائمة ملاحظات العملاء
     */
    public function index(Request $request)
    {
        $query = CustomerNote::with(['customer', 'addedBy'])
            ->active()
            ->latest();

        // فلترة حسب نوع الملاحظة
        if ($request->filled('note_type')) {
            $query->ofType($request->note_type);
        }

        // فلترة حسب العميل
        if ($request->filled('customer_id')) {
            $query->forCustomer($request->customer_id);
        }

        // فلترة حسب الأولوية
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // البحث في العنوان أو المحتوى
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $notes = $query->paginate(20);
        
        // إحصائيات سريعة
        $stats = [
            'total_notes' => CustomerNote::active()->count(),
            'marketing_notes' => CustomerNote::active()->ofType('marketing')->count(),
            'sales_notes' => CustomerNote::active()->ofType('sales')->count(),
            'high_priority' => CustomerNote::active()->where('priority', 'high')->count(),
        ];

        // قائمة العملاء للفلترة
        $customers = User::where('user_type', 'customer')
            ->select('id', 'name', 'email')
            ->orderBy('name')
            ->get();

        return view('admin.customer-notes.index', compact('notes', 'stats', 'customers'));
    }

    /**
     * عرض نموذج إنشاء ملاحظة جديدة
     */
    public function create()
    {
        $customers = User::where('user_type', 'customer')
            ->select('id', 'name', 'email')
            ->orderBy('name')
            ->get();

        return view('admin.customer-notes.create', compact('customers'));
    }

    /**
     * حفظ ملاحظة جديدة
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:users,id',
            'note_type' => 'required|in:marketing,sales,general',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'tags' => 'nullable|string',
            'follow_up_date' => 'nullable|date|after:now',
        ]);

        // تحويل الـ tags من string إلى array
        if ($request->filled('tags')) {
            $validated['tags'] = array_map('trim', explode(',', $request->tags));
        }

        $validated['added_by'] = Auth::guard('admin')->id();

        CustomerNote::create($validated);

        return redirect()->route('admin.customer-notes.index')
            ->with('success', 'تم إضافة الملاحظة بنجاح');
    }

    /**
     * عرض تفاصيل الملاحظة
     */
    public function show(CustomerNote $customerNote)
    {
        $customerNote->load(['customer', 'addedBy']);
        return view('admin.customer-notes.show', compact('customerNote'));
    }

    /**
     * عرض نموذج تعديل الملاحظة
     */
    public function edit(CustomerNote $customerNote)
    {
        $customers = User::where('user_type', 'customer')
            ->select('id', 'name', 'email')
            ->orderBy('name')
            ->get();

        return view('admin.customer-notes.edit', compact('customerNote', 'customers'));
    }

    /**
     * تحديث الملاحظة
     */
    public function update(Request $request, CustomerNote $customerNote)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:users,id',
            'note_type' => 'required|in:marketing,sales,general',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:active,archived,deleted',
            'tags' => 'nullable|string',
            'follow_up_date' => 'nullable|date',
        ]);

        // تحويل الـ tags من string إلى array
        if ($request->filled('tags')) {
            $validated['tags'] = array_map('trim', explode(',', $request->tags));
        }

        $customerNote->update($validated);

        return redirect()->route('admin.customer-notes.index')
            ->with('success', 'تم تحديث الملاحظة بنجاح');
    }

    /**
     * حذف الملاحظة
     */
    public function destroy(CustomerNote $customerNote)
    {
        $customerNote->update(['status' => 'deleted']);

        return redirect()->route('admin.customer-notes.index')
            ->with('success', 'تم حذف الملاحظة بنجاح');
    }

    /**
     * أرشفة الملاحظة
     */
    public function archive(CustomerNote $customerNote)
    {
        $customerNote->update(['status' => 'archived']);

        return redirect()->back()
            ->with('success', 'تم أرشفة الملاحظة بنجاح');
    }

    /**
     * استعادة الملاحظة
     */
    public function restore(CustomerNote $customerNote)
    {
        $customerNote->update(['status' => 'active']);

        return redirect()->back()
            ->with('success', 'تم استعادة الملاحظة بنجاح');
    }

    /**
     * عرض ملاحظات عميل معين
     */
    public function customerNotes(User $customer)
    {
        $notes = CustomerNote::with(['addedBy'])
            ->forCustomer($customer->id)
            ->active()
            ->latest()
            ->paginate(15);

        return view('admin.customer-notes.customer-notes', compact('notes', 'customer'));
    }

    /**
     * API للحصول على ملاحظات عميل معين (للاستخدام في AJAX)
     */
    public function getCustomerNotes(User $customer)
    {
        $notes = CustomerNote::with(['addedBy'])
            ->forCustomer($customer->id)
            ->active()
            ->latest()
            ->limit(10)
            ->get();

        return response()->json($notes);
    }
}