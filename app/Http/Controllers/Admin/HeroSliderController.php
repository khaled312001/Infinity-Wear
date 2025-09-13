<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSliderController extends Controller
{
    public function index()
    {
        $sliders = HeroSlider::ordered()->get();
        return view('admin.hero-slider.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.hero-slider.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'button_text' => 'nullable|string|max:100',
            'button_url' => 'nullable|string|max:255',
            'button_color' => 'nullable|string|max:7',
            'order' => 'nullable|integer',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('hero-sliders', 'public');
        }

        HeroSlider::create($data);

        return redirect()->route('admin.hero-slider.index')->with('success', 'تم إضافة السلايد بنجاح');
    }

    public function show(HeroSlider $heroSlider)
    {
        return view('admin.hero-slider.show', compact('heroSlider'));
    }

    public function edit(HeroSlider $heroSlider)
    {
        return view('admin.hero-slider.edit', compact('heroSlider'));
    }

    public function update(Request $request, HeroSlider $heroSlider)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'button_text' => 'nullable|string|max:100',
            'button_url' => 'nullable|string|max:255',
            'button_color' => 'nullable|string|max:7',
            'order' => 'nullable|integer',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('image')) {
            // Delete old image
            if ($heroSlider->image) {
                Storage::disk('public')->delete($heroSlider->image);
            }
            $data['image'] = $request->file('image')->store('hero-sliders', 'public');
        }

        $heroSlider->update($data);

        return redirect()->route('admin.hero-slider.index')->with('success', 'تم تحديث السلايد بنجاح');
    }

    public function destroy(HeroSlider $heroSlider)
    {
        if ($heroSlider->image) {
            Storage::disk('public')->delete($heroSlider->image);
        }
        
        $heroSlider->delete();

        return redirect()->route('admin.hero-slider.index')->with('success', 'تم حذف السلايد بنجاح');
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:hero_sliders,id',
            'items.*.order' => 'required|integer',
        ]);

        foreach ($request->items as $item) {
            HeroSlider::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }

    public function toggleActive(HeroSlider $heroSlider)
    {
        $heroSlider->update(['is_active' => !$heroSlider->is_active]);
        
        return redirect()->back()->with('success', 'تم تغيير حالة السلايد بنجاح');
    }
}