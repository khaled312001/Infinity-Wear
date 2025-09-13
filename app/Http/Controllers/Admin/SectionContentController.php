<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SectionContent;
use App\Models\HomeSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SectionContentController extends Controller
{
    public function index(HomeSection $homeSection)
    {
        $contents = $homeSection->allContents;
        return view('admin.section-contents.index', compact('homeSection', 'contents'));
    }

    public function create(HomeSection $homeSection)
    {
        $contentTypes = [
            'card' => 'بطاقة',
            'feature' => 'ميزة',
            'service' => 'خدمة',
            'testimonial' => 'شهادة',
            'team_member' => 'عضو فريق',
            'stat' => 'إحصائية',
            'step' => 'خطوة',
            'portfolio_item' => 'عمل سابق',
        ];

        return view('admin.section-contents.create', compact('homeSection', 'contentTypes'));
    }

    public function store(Request $request, HomeSection $homeSection)
    {
        $request->validate([
            'type' => 'required|string',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'icon' => 'nullable|string|max:100',
            'icon_color' => 'nullable|string|max:7',
            'button_text' => 'nullable|string|max:100',
            'button_url' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ]);

        $data = $request->all();
        $data['home_section_id'] = $homeSection->id;
        $data['extra_data'] = $request->input('extra_data', []);
        
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('section-contents', 'public');
        }

        SectionContent::create($data);

        return redirect()->route('admin.section-contents.index', $homeSection)->with('success', 'تم إضافة المحتوى بنجاح');
    }

    public function show(HomeSection $homeSection, SectionContent $sectionContent)
    {
        return view('admin.section-contents.show', compact('homeSection', 'sectionContent'));
    }

    public function edit(HomeSection $homeSection, SectionContent $sectionContent)
    {
        $contentTypes = [
            'card' => 'بطاقة',
            'feature' => 'ميزة',
            'service' => 'خدمة',
            'testimonial' => 'شهادة',
            'team_member' => 'عضو فريق',
            'stat' => 'إحصائية',
            'step' => 'خطوة',
            'portfolio_item' => 'عمل سابق',
        ];

        return view('admin.section-contents.edit', compact('homeSection', 'sectionContent', 'contentTypes'));
    }

    public function update(Request $request, HomeSection $homeSection, SectionContent $sectionContent)
    {
        $request->validate([
            'type' => 'required|string',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'icon' => 'nullable|string|max:100',
            'icon_color' => 'nullable|string|max:7',
            'button_text' => 'nullable|string|max:100',
            'button_url' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ]);

        $data = $request->all();
        $data['extra_data'] = $request->input('extra_data', []);
        
        if ($request->hasFile('image')) {
            // Delete old image
            if ($sectionContent->image) {
                Storage::disk('public')->delete($sectionContent->image);
            }
            $data['image'] = $request->file('image')->store('section-contents', 'public');
        }

        $sectionContent->update($data);

        return redirect()->route('admin.section-contents.index', $homeSection)->with('success', 'تم تحديث المحتوى بنجاح');
    }

    public function destroy(HomeSection $homeSection, SectionContent $sectionContent)
    {
        if ($sectionContent->image) {
            Storage::disk('public')->delete($sectionContent->image);
        }
        
        $sectionContent->delete();

        return redirect()->route('admin.section-contents.index', $homeSection)->with('success', 'تم حذف المحتوى بنجاح');
    }

    public function updateOrder(Request $request, HomeSection $homeSection)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:section_contents,id',
            'items.*.order' => 'required|integer',
        ]);

        foreach ($request->items as $item) {
            SectionContent::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }

    public function toggleActive(HomeSection $homeSection, SectionContent $sectionContent)
    {
        $sectionContent->update(['is_active' => !$sectionContent->is_active]);
        
        return redirect()->back()->with('success', 'تم تغيير حالة المحتوى بنجاح');
    }
}