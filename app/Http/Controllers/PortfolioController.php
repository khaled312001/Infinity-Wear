<?php

namespace App\Http\Controllers;

use App\Models\PortfolioItem;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    /**
     * عرض صفحة معرض الأعمال
     */
    public function index()
    {
        // الحصول على الفئات الفريدة لمعرض الأعمال
        $categories = PortfolioItem::select('category')
            ->distinct()
            ->pluck('category')
            ->toArray();

        // الحصول على جميع الأعمال مرتبة حسب الترتيب
        $portfolioItems = PortfolioItem::orderBy('sort_order')
            ->latest()
            ->get();

        // الحصول على الأعمال المميزة للعرض في القسم الرئيسي
        $featuredItems = PortfolioItem::where('is_featured', true)
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        return view('portfolio.index', compact('portfolioItems', 'categories', 'featuredItems'));
    }

    /**
     * عرض تفاصيل عمل معين
     */
    public function show($id)
    {
        $portfolioItem = PortfolioItem::findOrFail($id);

        // الحصول على أعمال مشابهة من نفس الفئة
        $relatedItems = PortfolioItem::where('id', '!=', $id)
            ->where('category', $portfolioItem->category)
            ->orderBy('sort_order')
            ->take(3)
            ->get();

        return view('portfolio.show', compact('portfolioItem', 'relatedItems'));
    }

    /**
     * تصفية الأعمال حسب الفئة (AJAX)
     */
    public function filterByCategory(Request $request)
    {
        $category = $request->category;

        $query = PortfolioItem::query();

        if ($category && $category != 'all') {
            $query->where('category', $category);
        }

        $portfolioItems = $query->orderBy('sort_order')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'html' => view('portfolio.partials.items', compact('portfolioItems'))->render()
        ]);
    }
}