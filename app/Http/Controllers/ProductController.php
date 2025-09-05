<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * عرض قائمة المنتجات
     */
    public function index(Request $request)
    {
        $query = Product::where('is_active', true);
        
        // البحث بالنص
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name_ar', 'LIKE', "%{$search}%")
                  ->orWhere('name_en', 'LIKE', "%{$search}%")
                  ->orWhere('description_ar', 'LIKE', "%{$search}%")
                  ->orWhere('description_en', 'LIKE', "%{$search}%");
            });
        }
        
        // فلترة حسب الفئة
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        // ترتيب المنتجات
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        
        $products = $query->with('category')->paginate(12);
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        
        return view('products.index', compact('products', 'categories'));
    }

    /**
     * عرض تفاصيل منتج واحد
     */
    public function show(Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }
        
        // المنتجات ذات الصلة من نفس الفئة
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();
        
        return view('products.show', compact('product', 'relatedProducts'));
    }

    /**
     * عرض نموذج إضافة منتج جديد (للإدارة)
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name_ar')->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * حفظ منتج جديد (للإدارة)
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'sku' => 'required|string|unique:products,sku',
            'stock_quantity' => 'required|integer|min:0',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $product = Product::create($validatedData);

        // رفع الصور
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->extension();
                $image->move(public_path('images/products'), $imageName);
                $images[] = 'images/products/' . $imageName;
            }
            $product->images = json_encode($images);
            $product->save();
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'تم إضافة المنتج بنجاح');
    }

    /**
     * عرض نموذج تعديل المنتج (للإدارة)
     */
    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->orderBy('name_ar')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * تحديث المنتج (للإدارة)
     */
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'stock_quantity' => 'required|integer|min:0',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $product->update($validatedData);

        // رفع الصور الجديدة
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->extension();
                $image->move(public_path('images/products'), $imageName);
                $images[] = 'images/products/' . $imageName;
            }
            $product->images = json_encode($images);
            $product->save();
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'تم تحديث المنتج بنجاح');
    }

    /**
     * حذف المنتج (للإدارة)
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')
            ->with('success', 'تم حذف المنتج بنجاح');
    }
}
