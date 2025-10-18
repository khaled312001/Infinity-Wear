<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServicesController extends Controller
{
    /**
     * Display the services page
     */
    public function index()
    {
        $services = Service::active()->ordered()->get();
        return view('services', compact('services'));
    }

    /**
     * Display the admin services management page
     */
    public function adminIndex()
    {
        $services = Service::ordered()->get();
        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for editing the specified service
     */
    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Store a new service
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:255',
            'image' => [
                'nullable',
                'file',
                'max:2048',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/svg+xml'];
                        $allowedExtensions = ['jpeg', 'jpg', 'png', 'gif', 'svg'];
                        
                        $mimeType = $value->getMimeType();
                        $extension = strtolower($value->getClientOriginalExtension());
                        
                        if (!in_array($mimeType, $allowedMimes) && !in_array($extension, $allowedExtensions)) {
                            $fail('الصورة يجب أن تكون من نوع: jpeg, jpg, png, gif, svg');
                        }
                    }
                }
            ],
            'features' => 'nullable|array',
            'features.*' => 'string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($validated['title']) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('images/services', $imageName, 'public');
            $validated['image'] = $imagePath;
        }

        // Set default order if not provided
        if (!isset($validated['order'])) {
            $validated['order'] = Service::max('order') + 1;
        }

        // Set default active status - convert string to boolean
        $validated['is_active'] = (bool) $request->input('is_active', true);

        Service::create($validated);

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'تم إضافة الخدمة بنجاح']);
        }

        return redirect()->route('admin.services.index')
            ->with('success', 'تم إضافة الخدمة بنجاح');
    }

    /**
     * Update an existing service
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:255',
            'image' => [
                'nullable',
                'file',
                'max:2048',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/svg+xml'];
                        $allowedExtensions = ['jpeg', 'jpg', 'png', 'gif', 'svg'];
                        
                        $mimeType = $value->getMimeType();
                        $extension = strtolower($value->getClientOriginalExtension());
                        
                        if (!in_array($mimeType, $allowedMimes) && !in_array($extension, $allowedExtensions)) {
                            $fail('الصورة يجب أن تكون من نوع: jpeg, jpg, png, gif, svg');
                        }
                    }
                }
            ],
            'features' => 'nullable|array',
            'features.*' => 'string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($service->image && Storage::disk('public')->exists($service->image)) {
                Storage::disk('public')->delete($service->image);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($validated['title']) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('images/services', $imageName, 'public');
            $validated['image'] = $imagePath;
        }

        // Set active status - convert string to boolean
        $validated['is_active'] = (bool) $request->input('is_active', true);

        $service->update($validated);

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'تم تحديث الخدمة بنجاح']);
        }

        return redirect()->route('admin.services.index')
            ->with('success', 'تم تحديث الخدمة بنجاح');
    }

    /**
     * Delete a service
     */
    public function destroy(Service $service)
    {
        // Delete image if exists
        if ($service->image && Storage::disk('public')->exists($service->image)) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'تم حذف الخدمة بنجاح']);
        }

        return redirect()->route('admin.services.index')
            ->with('success', 'تم حذف الخدمة بنجاح');
    }

    /**
     * Toggle service active status
     */
    public function toggleStatus(Service $service)
    {
        $service->update(['is_active' => !$service->is_active]);

        $status = $service->is_active ? 'مفعلة' : 'معطلة';
        
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => "تم تغيير حالة الخدمة إلى {$status}"]);
        }

        return redirect()->route('admin.services.index')
            ->with('success', "تم تغيير حالة الخدمة إلى {$status}");
    }

    /**
     * Update service order
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'services' => 'required|array',
            'services.*.id' => 'required|exists:services,id',
            'services.*.order' => 'required|integer|min:0'
        ]);

        foreach ($request->services as $serviceData) {
            Service::where('id', $serviceData['id'])
                ->update(['order' => $serviceData['order']]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Activate all services
     */
    public function activateAll()
    {
        Service::query()->update(['is_active' => true]);

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'تم تفعيل جميع الخدمات بنجاح']);
        }

        return redirect()->back()->with('success', 'تم تفعيل جميع الخدمات بنجاح');
    }
}