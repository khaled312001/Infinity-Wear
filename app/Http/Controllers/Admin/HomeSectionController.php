<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use Illuminate\Http\Request;

class HomeSectionController extends Controller
{
    public function index()
    {
        $sections = HomeSection::ordered()->with('allContents')->get();
        return view('admin.home-sections.index', compact('sections'));
    }

    public function create()
    {
        $sectionTypes = [
            'services' => 'خدماتنا',
            'about' => 'من نحن',
            'features' => 'مميزاتنا',
            'testimonials' => 'آراء العملاء',
            'portfolio' => 'معرض أعمالنا',
            'team' => 'فريق العمل',
            'contact' => 'اتصل بنا',
            'stats' => 'الإحصائيات',
            'process' => 'كيف نعمل',
            'custom' => 'قسم مخصص',
        ];

        return view('admin.home-sections.create', compact('sectionTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'description' => 'nullable|string',
            'background_color' => 'nullable|string|max:7',
            'text_color' => 'nullable|string|max:7',
            'section_type' => 'required|string',
            'order' => 'nullable|integer',
        ]);

        $data = $request->all();
        $data['settings'] = $request->input('settings', []);

        HomeSection::create($data);

        return redirect()->route('admin.home-sections.index')->with('success', 'تم إضافة القسم بنجاح');
    }

    public function show(HomeSection $homeSection)
    {
        $homeSection->load('allContents');
        return view('admin.home-sections.show', compact('homeSection'));
    }

    public function edit(HomeSection $homeSection)
    {
        $sectionTypes = [
            'services' => 'خدماتنا',
            'about' => 'من نحن',
            'features' => 'مميزاتنا',
            'testimonials' => 'آراء العملاء',
            'portfolio' => 'معرض أعمالنا',
            'team' => 'فريق العمل',
            'contact' => 'اتصل بنا',
            'stats' => 'الإحصائيات',
            'process' => 'كيف نعمل',
            'custom' => 'قسم مخصص',
        ];

        return view('admin.home-sections.edit', compact('homeSection', 'sectionTypes'));
    }

    public function update(Request $request, HomeSection $homeSection)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'description' => 'nullable|string',
            'background_color' => 'nullable|string|max:7',
            'text_color' => 'nullable|string|max:7',
            'section_type' => 'required|string',
            'order' => 'nullable|integer',
        ]);

        $data = $request->all();
        $data['settings'] = $request->input('settings', []);

        $homeSection->update($data);

        return redirect()->route('admin.home-sections.index')->with('success', 'تم تحديث القسم بنجاح');
    }

    public function destroy(HomeSection $homeSection)
    {
        $homeSection->delete();

        return redirect()->route('admin.home-sections.index')->with('success', 'تم حذف القسم بنجاح');
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:home_sections,id',
            'items.*.order' => 'required|integer',
        ]);

        foreach ($request->items as $item) {
            HomeSection::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }

    public function toggleActive(HomeSection $homeSection)
    {
        $homeSection->update(['is_active' => !$homeSection->is_active]);
        
        return redirect()->back()->with('success', 'تم تغيير حالة القسم بنجاح');
    }
}