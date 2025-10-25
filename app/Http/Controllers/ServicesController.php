<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\CloudinaryService;
use Illuminate\Support\Facades\Log;

class ServicesController extends Controller
{
    protected $cloudinaryService;

    public function __construct(CloudinaryService $cloudinaryService)
    {
        $this->cloudinaryService = $cloudinaryService;
    }
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

        // Handle image upload with Cloudinary
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            
            // Upload to Cloudinary
            $uploadResult = $this->cloudinaryService->uploadFile($image, 'infinitywearsa/services');
            
            if ($uploadResult['success']) {
                // Store locally as backup
                $imageName = time() . '_' . Str::slug($validated['title']) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('images/services', $imageName, 'public');
                
                // Store Cloudinary data in image field
                $validated['image'] = json_encode([
                    'cloudinary' => [
                        'public_id' => $uploadResult['public_id'],
                        'secure_url' => $uploadResult['secure_url'],
                        'url' => $uploadResult['url'],
                        'format' => $uploadResult['format'],
                        'width' => $uploadResult['width'],
                        'height' => $uploadResult['height'],
                        'bytes' => $uploadResult['bytes'],
                    ],
                    'file_path' => $imagePath,
                    'uploaded_at' => now()->toISOString(),
                ]);
                
                Log::info('Service image uploaded to Cloudinary successfully', [
                    'public_id' => $uploadResult['public_id'],
                    'file_name' => $image->getClientOriginalName(),
                    'file_size' => $image->getSize(),
                    'cloudinary_url' => $uploadResult['secure_url']
                ]);
            } else {
                // Fallback to local storage only
                $imageName = time() . '_' . Str::slug($validated['title']) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('images/services', $imageName, 'public');
                $validated['image'] = $imagePath;
                
                Log::warning('Cloudinary upload failed for service image, using local storage', [
                    'error' => $uploadResult['error'] ?? 'Unknown error',
                    'file_name' => $image->getClientOriginalName(),
                    'local_path' => $imagePath
                ]);
            }
        }

        // Set default order if not provided
        if (!isset($validated['order'])) {
            $validated['order'] = Service::max('order') + 1;
        }

        // Set default active status - handle checkbox properly
        $isActive = $request->input('is_active', true);
        if (is_array($isActive)) {
            // If it's an array (checkbox + hidden input), check if '1' is in the array
            $validated['is_active'] = in_array('1', $isActive);
        } else {
            // If it's a single value, convert to boolean
            $validated['is_active'] = (bool) $isActive;
        }

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

        // Handle image upload with Cloudinary
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            
            // Delete old image from Cloudinary and local storage
            if ($service->image) {
                $oldImageData = json_decode($service->image, true);
                if ($oldImageData && isset($oldImageData['cloudinary']['public_id'])) {
                    $this->cloudinaryService->deleteFile($oldImageData['cloudinary']['public_id']);
                }
                if ($oldImageData && isset($oldImageData['file_path']) && Storage::disk('public')->exists($oldImageData['file_path'])) {
                    Storage::disk('public')->delete($oldImageData['file_path']);
                } elseif (is_string($service->image) && Storage::disk('public')->exists($service->image)) {
                    Storage::disk('public')->delete($service->image);
                }
            }
            
            // Upload to Cloudinary
            $uploadResult = $this->cloudinaryService->uploadFile($image, 'infinitywearsa/services');
            
            if ($uploadResult['success']) {
                // Store locally as backup
                $imageName = time() . '_' . Str::slug($validated['title']) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('images/services', $imageName, 'public');
                
                // Store Cloudinary data in image field
                $validated['image'] = json_encode([
                    'cloudinary' => [
                        'public_id' => $uploadResult['public_id'],
                        'secure_url' => $uploadResult['secure_url'],
                        'url' => $uploadResult['url'],
                        'format' => $uploadResult['format'],
                        'width' => $uploadResult['width'],
                        'height' => $uploadResult['height'],
                        'bytes' => $uploadResult['bytes'],
                    ],
                    'file_path' => $imagePath,
                    'uploaded_at' => now()->toISOString(),
                ]);
                
                Log::info('Service image updated on Cloudinary successfully', [
                    'public_id' => $uploadResult['public_id'],
                    'file_name' => $image->getClientOriginalName(),
                    'file_size' => $image->getSize(),
                    'cloudinary_url' => $uploadResult['secure_url']
                ]);
            } else {
                // Fallback to local storage only
                $imageName = time() . '_' . Str::slug($validated['title']) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('images/services', $imageName, 'public');
                $validated['image'] = $imagePath;
                
                Log::warning('Cloudinary upload failed for service image update, using local storage', [
                    'error' => $uploadResult['error'] ?? 'Unknown error',
                    'file_name' => $image->getClientOriginalName(),
                    'local_path' => $imagePath
                ]);
            }
        }

        // Set active status - handle checkbox properly
        $isActive = $request->input('is_active');
        if (is_array($isActive)) {
            // If it's an array (checkbox + hidden input), check if '1' is in the array
            $validated['is_active'] = in_array('1', $isActive);
        } else {
            // If it's a single value, convert to boolean
            $validated['is_active'] = (bool) $isActive;
        }

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
        // Delete image from Cloudinary and local storage
        if ($service->image) {
            $imageData = json_decode($service->image, true);
            if ($imageData && isset($imageData['cloudinary']['public_id'])) {
                $deleteResult = $this->cloudinaryService->deleteFile($imageData['cloudinary']['public_id']);
                if ($deleteResult['success']) {
                    Log::info('Service image deleted from Cloudinary', ['public_id' => $imageData['cloudinary']['public_id']]);
                } else {
                    Log::warning('Failed to delete service image from Cloudinary', ['error' => $deleteResult['error']]);
                }
            }
            if ($imageData && isset($imageData['file_path']) && Storage::disk('public')->exists($imageData['file_path'])) {
                Storage::disk('public')->delete($imageData['file_path']);
            } elseif (is_string($service->image) && Storage::disk('public')->exists($service->image)) {
                Storage::disk('public')->delete($service->image);
            }
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