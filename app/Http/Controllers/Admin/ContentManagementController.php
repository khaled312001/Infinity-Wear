<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContentManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $content = ContentManagement::ordered()->get();
        
        return view('admin.content-management.index', compact('content'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.content-management.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'page_name' => 'required|string|max:255',
            'section_name' => 'required|string|max:255',
            'content_type' => 'required|in:text,image,video,gallery',
            'title_ar' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'content_ar' => 'nullable|string',
            'content_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video_url' => 'nullable|url',
            'button_text_ar' => 'nullable|string|max:255',
            'button_text_en' => 'nullable|string|max:255',
            'button_url' => 'nullable|url',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $data = $request->except(['image', 'gallery_images']);

        // Handle single image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('content-management', 'public');
            $data['image_path'] = $imagePath;
        }

        // Handle gallery images
        if ($request->hasFile('gallery_images')) {
            $galleryPaths = [];
            foreach ($request->file('gallery_images') as $image) {
                $galleryPaths[] = $image->store('content-management/gallery', 'public');
            }
            $data['gallery_images'] = $galleryPaths;
        }

        // Set default values
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        ContentManagement::create($data);

        return redirect()->route('admin.content-management.index')
            ->with('success', 'تم إنشاء المحتوى بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(ContentManagement $contentManagement)
    {
        return view('admin.content-management.show', compact('contentManagement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContentManagement $contentManagement)
    {
        return view('admin.content-management.edit', compact('contentManagement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContentManagement $contentManagement)
    {
        $request->validate([
            'page_name' => 'required|string|max:255',
            'section_name' => 'required|string|max:255',
            'content_type' => 'required|in:text,image,video,gallery',
            'title_ar' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'content_ar' => 'nullable|string',
            'content_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video_url' => 'nullable|url',
            'button_text_ar' => 'nullable|string|max:255',
            'button_text_en' => 'nullable|string|max:255',
            'button_url' => 'nullable|url',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $data = $request->except(['image', 'gallery_images']);

        // Handle single image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($contentManagement->image_path) {
                Storage::disk('public')->delete($contentManagement->image_path);
            }
            
            $imagePath = $request->file('image')->store('content-management', 'public');
            $data['image_path'] = $imagePath;
        }

        // Handle gallery images
        if ($request->hasFile('gallery_images')) {
            // Delete old gallery images
            if ($contentManagement->gallery_images) {
                foreach ($contentManagement->gallery_images as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            
            $galleryPaths = [];
            foreach ($request->file('gallery_images') as $image) {
                $galleryPaths[] = $image->store('content-management/gallery', 'public');
            }
            $data['gallery_images'] = $galleryPaths;
        }

        // Set boolean values
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');

        $contentManagement->update($data);

        return redirect()->route('admin.content-management.index')
            ->with('success', 'تم تحديث المحتوى بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContentManagement $contentManagement)
    {
        // Delete associated images
        if ($contentManagement->image_path) {
            Storage::disk('public')->delete($contentManagement->image_path);
        }
        
        if ($contentManagement->gallery_images) {
            foreach ($contentManagement->gallery_images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $contentManagement->delete();

        return redirect()->route('admin.content-management.index')
            ->with('success', 'تم حذف المحتوى بنجاح');
    }

    /**
     * Toggle the status of the specified resource.
     */
    public function toggleStatus(ContentManagement $contentManagement)
    {
        $contentManagement->update([
            'is_active' => !$contentManagement->is_active
        ]);

        $status = $contentManagement->is_active ? 'مفعل' : 'معطل';
        
        return redirect()->back()
            ->with('success', "تم تغيير حالة المحتوى إلى {$status}");
    }
}
