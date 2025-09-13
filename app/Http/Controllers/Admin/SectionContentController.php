<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use App\Models\SectionContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SectionContentController extends Controller
{
    /**
     * عرض قائمة محتويات القسم
     */
    public function index(HomeSection $homeSection)
    {
        $contents = $homeSection->contents()->orderBy('sort_order')->get();
        return view('admin.section-contents.index', compact('homeSection', 'contents'));
    }

    /**
     * عرض نموذج إنشاء محتوى جديد
     */
    public function create(HomeSection $homeSection)
    {
        return view('admin.section-contents.create', compact('homeSection'));
    }

    /**
     * حفظ محتوى جديد
     */
    public function store(Request $request, HomeSection $homeSection)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'content_type' => 'required|string|in:text,image,video,icon,button,card,testimonial',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'video_url' => 'nullable|url',
            'icon_class' => 'nullable|string|max:100',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:500',
            'button_style' => 'nullable|string|in:primary,secondary,outline,link',
            'custom_data' => 'nullable|json',
            'is_active' => 'boolean',
        ]);

        $data = $request->except(['image']);
        
        // معالجة الصورة
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('section-contents', 'public');
        }

        // تحديد ترتيب المحتوى
        $data['sort_order'] = $homeSection->contents()->max('sort_order') + 1;
        $data['is_active'] = $request->has('is_active');
        $data['home_section_id'] = $homeSection->id;

        SectionContent::create($data);

        return redirect()->route('admin.home-sections.section-contents.index', $homeSection)
            ->with('success', 'تم إنشاء المحتوى بنجاح');
    }

    /**
     * عرض تفاصيل المحتوى
     */
    public function show(SectionContent $sectionContent)
    {
        return view('admin.section-contents.show', compact('sectionContent'));
    }

    /**
     * عرض نموذج تعديل المحتوى
     */
    public function edit(SectionContent $sectionContent)
    {
        return view('admin.section-contents.edit', compact('sectionContent'));
    }

    /**
     * تحديث المحتوى
     */
    public function update(Request $request, SectionContent $sectionContent)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'content_type' => 'required|string|in:text,image,video,icon,button,card,testimonial',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'video_url' => 'nullable|url',
            'icon_class' => 'nullable|string|max:100',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:500',
            'button_style' => 'nullable|string|in:primary,secondary,outline,link',
            'custom_data' => 'nullable|json',
            'is_active' => 'boolean',
        ]);

        $data = $request->except(['image']);
        
        // معالجة الصورة الجديدة
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة
            if ($sectionContent->image && Storage::disk('public')->exists($sectionContent->image)) {
                Storage::disk('public')->delete($sectionContent->image);
            }
            $data['image'] = $request->file('image')->store('section-contents', 'public');
        }

        $data['is_active'] = $request->has('is_active');

        $sectionContent->update($data);

        return redirect()->route('admin.home-sections.section-contents.index', $sectionContent->homeSection)
            ->with('success', 'تم تحديث المحتوى بنجاح');
    }

    /**
     * حذف المحتوى
     */
    public function destroy(SectionContent $sectionContent)
    {
        $homeSection = $sectionContent->homeSection;
        
        // حذف الصورة
        if ($sectionContent->image && Storage::disk('public')->exists($sectionContent->image)) {
            Storage::disk('public')->delete($sectionContent->image);
        }

        $sectionContent->delete();

        return redirect()->route('admin.home-sections.section-contents.index', $homeSection)
            ->with('success', 'تم حذف المحتوى بنجاح');
    }

    /**
     * تحديث ترتيب المحتويات
     */
    public function updateOrder(Request $request, HomeSection $homeSection)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:section_contents,id',
            'items.*.sort_order' => 'required|integer',
        ]);

        foreach ($request->items as $item) {
            SectionContent::where('id', $item['id'])
                ->where('home_section_id', $homeSection->id)
                ->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json(['success' => true, 'message' => 'تم تحديث الترتيب بنجاح']);
    }

    /**
     * تفعيل/إلغاء تفعيل المحتوى
     */
    public function toggleActive(SectionContent $sectionContent)
    {
        $sectionContent->update(['is_active' => !$sectionContent->is_active]);

        $status = $sectionContent->is_active ? 'تفعيل' : 'إلغاء تفعيل';
        return redirect()->back()->with('success', "تم {$status} المحتوى بنجاح");
    }
}