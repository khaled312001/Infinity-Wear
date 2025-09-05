<?php

namespace App\Http\Controllers;

use App\Models\CustomDesign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomDesignController extends Controller
{
    public function index()
    {
        $designs = CustomDesign::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('custom-designs.index', compact('designs'));
    }

    public function create()
    {
        return view('custom-designs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'design_data' => 'required|json',
        ]);

        CustomDesign::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'design_data' => json_decode($request->design_data, true),
            'status' => 'draft'
        ]);

        return redirect()->route('custom-designs.index')
            ->with('success', 'تم إنشاء التصميم بنجاح');
    }

    public function show(CustomDesign $customDesign)
    {
        $this->authorize('view', $customDesign);
        return view('custom-designs.show', compact('customDesign'));
    }

    public function edit(CustomDesign $customDesign)
    {
        $this->authorize('update', $customDesign);
        return view('custom-designs.edit', compact('customDesign'));
    }

    public function update(Request $request, CustomDesign $customDesign)
    {
        $this->authorize('update', $customDesign);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'design_data' => 'required|json',
        ]);

        $customDesign->update([
            'name' => $request->name,
            'description' => $request->description,
            'design_data' => json_decode($request->design_data, true),
        ]);

        return redirect()->route('custom-designs.index')
            ->with('success', 'تم تحديث التصميم بنجاح');
    }

    public function destroy(CustomDesign $customDesign)
    {
        $this->authorize('delete', $customDesign);
        $customDesign->delete();

        return redirect()->route('custom-designs.index')
            ->with('success', 'تم حذف التصميم بنجاح');
    }
}
