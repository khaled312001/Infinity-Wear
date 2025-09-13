<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use Illuminate\Http\Request;

class HomeSectionController extends Controller
{
    /**
     * عرض قائمة أقسام الصفحة الرئيسية
     */
    public function index()
    {
        $sections = HomeSection::orderBy('sort_order')->with('contents')->get();
        return view('admin.home-sections.index', compact('sections'));
    }

    /**
     * عرض نموذج إنشاء قسم جديد
     */
    public function create()
    {
        return view('admin.home-sections.create');
    }

    /**
     * حفظ قسم جديد
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'section_type' => 'required|string|in:hero,services,features,about,portfolio,testimonials,contact,custom',
            'layout_type' => 'required|string|in:full_width,container,grid_2,grid_3,grid_4,carousel',
            'background_color' => 'nullable|string|max:7',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'text_color' => 'nullable|string|max:7',
            'custom_css' => 'nullable|string',
            'custom_js' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $data = $request->except(['background_image']);
        
        // معالجة صورة الخلفية
        if ($request->hasFile('background_image')) {
            $data['background_image'] = $request->file('background_image')->store('home-sections', 'public');
        }

        // تحديد ترتيب القسم
        $data['sort_order'] = HomeSection::max('sort_order') + 1;
        $data['is_active'] = $request->has('is_active');

        HomeSection::create($data);

        return redirect()->route('admin.home-sections.index')
            ->with('success', 'تم إنشاء القسم بنجاح');
    }

    /**
     * عرض تفاصيل القسم
     */
    public function show(HomeSection $homeSection)
    {
        $homeSection->load('contents');
        return view('admin.home-sections.show', compact('homeSection'));
    }

    /**
     * عرض نموذج تعديل القسم
     */
    public function edit(HomeSection $homeSection)
    {
        return view('admin.home-sections.edit', compact('homeSection'));
    }

    /**
     * تحديث القسم
     */
    public function update(Request $request, HomeSection $homeSection)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'section_type' => 'required|string|in:hero,services,features,about,portfolio,testimonials,contact,custom',
            'layout_type' => 'required|string|in:full_width,container,grid_2,grid_3,grid_4,carousel',
            'background_color' => 'nullable|string|max:7',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'text_color' => 'nullable|string|max:7',
            'custom_css' => 'nullable|string',
            'custom_js' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $data = $request->except(['background_image']);
        
        // معالجة صورة الخلفية الجديدة
        if ($request->hasFile('background_image')) {
            // حذف الصورة القديمة
            if ($homeSection->background_image && Storage::disk('public')->exists($homeSection->background_image)) {
                Storage::disk('public')->delete($homeSection->background_image);
            }
            $data['background_image'] = $request->file('background_image')->store('home-sections', 'public');
        }

        $data['is_active'] = $request->has('is_active');

        $homeSection->update($data);

        return redirect()->route('admin.home-sections.index')
            ->with('success', 'تم تحديث القسم بنجاح');
    }

    /**
     * حذف القسم
     */
    public function destroy(HomeSection $homeSection)
    {
        // حذف صورة الخلفية
        if ($homeSection->background_image && Storage::disk('public')->exists($homeSection->background_image)) {
            Storage::disk('public')->delete($homeSection->background_image);
        }

        // حذف محتويات القسم
        $homeSection->contents()->delete();

        $homeSection->delete();

        return redirect()->route('admin.home-sections.index')
            ->with('success', 'تم حذف القسم بنجاح');
    }

    /**
     * تحديث ترتيب الأقسام
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:home_sections,id',
            'items.*.sort_order' => 'required|integer',
        ]);

        foreach ($request->items as $item) {
            HomeSection::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json(['success' => true, 'message' => 'تم تحديث الترتيب بنجاح']);
    }

    /**
     * تفعيل/إلغاء تفعيل القسم
     */
    public function toggleActive(HomeSection $homeSection)
    {
        $homeSection->update(['is_active' => !$homeSection->is_active]);

        $status = $homeSection->is_active ? 'تفعيل' : 'إلغاء تفعيل';
        return redirect()->back()->with('success', "تم {$status} القسم بنجاح");
    }
}