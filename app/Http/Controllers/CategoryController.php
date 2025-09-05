<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * عرض قائمة الفئات
     */
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->withCount('products')
            ->get();
        
        return view('categories.index', compact('categories'));
    }

    /**
     * عرض منتجات فئة محددة
     */
    public function show(Category $category, Request $request)
    {
        if (!$category->is_active) {
            abort(404);
        }
        
        $query = $category->products()->where('is_active', true);
        
        // البحث بالنص
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name_ar', 'LIKE', "%{$search}%")
                  ->orWhere('name_en', 'LIKE', "%{$search}%")
                  ->orWhere('description_ar', 'LIKE', "%{$search}%");
            });
        }
        
        // ترتيب المنتجات
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        
        $products = $query->paginate(12);
        
        return view('categories.show', compact('category', 'products'));
    }

    /**
     * عرض نموذج إضافة فئة جديدة (للإدارة)
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * حفظ فئة جديدة (للإدارة)
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $category = Category::create($validatedData);

        // رفع الصورة
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/categories'), $imageName);
            $category->image = 'images/categories/' . $imageName;
            $category->save();
        }

        return redirect()->route('admin.categories.index')
            ->with('success', 'تم إضافة الفئة بنجاح');
    }

    /**
     * عرض نموذج تعديل الفئة (للإدارة)
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * تحديث الفئة (للإدارة)
     */
    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'sort_order' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $category->update($validatedData);

        // رفع الصورة الجديدة
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/categories'), $imageName);
            $category->image = 'images/categories/' . $imageName;
            $category->save();
        }

        return redirect()->route('admin.categories.index')
            ->with('success', 'تم تحديث الفئة بنجاح');
    }

    /**
     * حذف الفئة (للإدارة)
     */
    public function destroy(Category $category)
    {
        // التحقق من وجود منتجات في الفئة
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'لا يمكن حذف الفئة لوجود منتجات بها');
        }
        
        $category->delete();
        return redirect()->route('admin.categories.index')
            ->with('success', 'تم حذف الفئة بنجاح');
    }
}
