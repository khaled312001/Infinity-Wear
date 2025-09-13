<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSliderController extends Controller
{
    /**
     * عرض قائمة شرائح البطل
     */
    public function index()
    {
        $sliders = HeroSlider::orderBy('sort_order')->get();
        return view('admin.hero-slider.index', compact('sliders'));
    }

    /**
     * عرض نموذج إنشاء شريحة جديدة
     */
    public function create()
    {
        return view('admin.hero-slider.create');
    }

    /**
     * حفظ شريحة جديدة
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|url|max:500',
            'text_color' => 'nullable|string|max:7',
            'overlay_opacity' => 'nullable|numeric|min:0|max:1',
            'animation_type' => 'nullable|string|in:fade,slide,zoom',
            'is_active' => 'boolean',
        ]);

        $data = $request->except(['image']);
        
        // معالجة الصورة
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('hero-slider', 'public');
        }

        // تحديد ترتيب الشريحة
        $data['sort_order'] = HeroSlider::max('sort_order') + 1;
        $data['is_active'] = $request->has('is_active');

        HeroSlider::create($data);

        return redirect()->route('admin.hero-slider.index')
            ->with('success', 'تم إنشاء الشريحة بنجاح');
    }

    /**
     * عرض تفاصيل الشريحة
     */
    public function show(HeroSlider $heroSlider)
    {
        return view('admin.hero-slider.show', compact('heroSlider'));
    }

    /**
     * عرض نموذج تعديل الشريحة
     */
    public function edit(HeroSlider $heroSlider)
    {
        return view('admin.hero-slider.edit', compact('heroSlider'));
    }

    /**
     * تحديث الشريحة
     */
    public function update(Request $request, HeroSlider $heroSlider)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|url|max:500',
            'text_color' => 'nullable|string|max:7',
            'overlay_opacity' => 'nullable|numeric|min:0|max:1',
            'animation_type' => 'nullable|string|in:fade,slide,zoom',
            'is_active' => 'boolean',
        ]);

        $data = $request->except(['image']);
        
        // معالجة الصورة الجديدة
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة
            if ($heroSlider->image && Storage::disk('public')->exists($heroSlider->image)) {
                Storage::disk('public')->delete($heroSlider->image);
            }
            $data['image'] = $request->file('image')->store('hero-slider', 'public');
        }

        $data['is_active'] = $request->has('is_active');

        $heroSlider->update($data);

        return redirect()->route('admin.hero-slider.index')
            ->with('success', 'تم تحديث الشريحة بنجاح');
    }

    /**
     * حذف الشريحة
     */
    public function destroy(HeroSlider $heroSlider)
    {
        // حذف الصورة
        if ($heroSlider->image && Storage::disk('public')->exists($heroSlider->image)) {
            Storage::disk('public')->delete($heroSlider->image);
        }

        $heroSlider->delete();

        return redirect()->route('admin.hero-slider.index')
            ->with('success', 'تم حذف الشريحة بنجاح');
    }

    /**
     * تحديث ترتيب الشرائح
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:hero_sliders,id',
            'items.*.sort_order' => 'required|integer',
        ]);

        foreach ($request->items as $item) {
            HeroSlider::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json(['success' => true, 'message' => 'تم تحديث الترتيب بنجاح']);
    }

    /**
     * تفعيل/إلغاء تفعيل الشريحة
     */
    public function toggleActive(HeroSlider $heroSlider)
    {
        $heroSlider->update(['is_active' => !$heroSlider->is_active]);

        $status = $heroSlider->is_active ? 'تفعيل' : 'إلغاء تفعيل';
        return redirect()->back()->with('success', "تم {$status} الشريحة بنجاح");
    }
}