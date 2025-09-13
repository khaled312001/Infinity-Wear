<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CustomDesign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomDesignController extends Controller
{
    /**
     * عرض صفحة إنشاء التصميم (متاحة للجميع)
     */
    public function create()
    {
        return view('custom-designs.create');
    }

    public function enhancedCreate()
    {
        return view('custom-designs.enhanced-create');
    }

    /**
     * حفظ التصميم الجديد
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'design_data' => 'required|json',
        ]);

        // إذا كان المستخدم مسجل دخول، احفظ التصميم في حسابه
        if (Auth::check()) {
            $validatedData['user_id'] = Auth::id();
            CustomDesign::create($validatedData);
            
            return redirect()->route('custom-designs.index')
                ->with('success', 'تم حفظ التصميم بنجاح!');
        } else {
            // إذا لم يكن مسجل دخول، احفظ التصميم بدون ربطه بمستخدم
            $validatedData['user_id'] = null;
            $design = CustomDesign::create($validatedData);
            
            return redirect()->route('custom-designs.create')
                ->with('success', 'تم حفظ التصميم بنجاح! يمكنك تسجيل الدخول لاحقاً لإدارة تصاميمك المحفوظة.')
                ->with('design_id', $design->id);
        }
    }

    /**
     * عرض تصاميم المستخدم (يتطلب تسجيل دخول)
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('message', 'يرجى تسجيل الدخول لعرض تصاميمك');
        }

        $designs = CustomDesign::where('user_id', Auth::id())
            ->latest()
            ->paginate(12);

        return view('custom-designs.index', compact('designs'));
    }

    /**
     * عرض تفاصيل تصميم محدد
     */
    public function show(CustomDesign $customDesign)
    {
        // التأكد من أن التصميم يخص المستخدم الحالي أو الإدارة
        if ($customDesign->user_id !== Auth::id() && !Auth::guard('admin')->check()) {
            abort(403);
        }

        return view('custom-designs.show', compact('customDesign'));
    }

    /**
     * عرض نموذج تعديل التصميم
     */
    public function edit(CustomDesign $customDesign)
    {
        // التأكد من أن التصميم يخص المستخدم الحالي
        if ($customDesign->user_id !== Auth::id()) {
            abort(403);
        }

        return view('custom-designs.edit', compact('customDesign'));
    }

    /**
     * تحديث التصميم
     */
    public function update(Request $request, CustomDesign $customDesign)
    {
        // التأكد من أن التصميم يخص المستخدم الحالي
        if ($customDesign->user_id !== Auth::id()) {
            abort(403);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'design_data' => 'required|json',
        ]);

        $customDesign->update($validatedData);

        return redirect()->route('custom-designs.index')
            ->with('success', 'تم تحديث التصميم بنجاح!');
    }

    /**
     * حذف التصميم
     */
    public function destroy(CustomDesign $customDesign)
    {
        // التأكد من أن التصميم يخص المستخدم الحالي أو الإدارة
        if ($customDesign->user_id !== Auth::id() && !Auth::guard('admin')->check()) {
            abort(403);
        }

        $customDesign->delete();

        return redirect()->route('custom-designs.index')
            ->with('success', 'تم حذف التصميم بنجاح!');
    }
}
