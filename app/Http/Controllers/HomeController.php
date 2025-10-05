<?php

namespace App\Http\Controllers;

use App\Models\PortfolioItem;
use App\Models\Testimonial;
use App\Models\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * عرض الصفحة الرئيسية
     */
    public function index()
    {
        // الحصول على الأعمال المميزة للعرض في الصفحة الرئيسية
        $featuredPortfolio = PortfolioItem::where('is_featured', true)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->take(12)
            ->get();

        // الحصول على جميع الأعمال للعرض في المعرض
        $portfolioItems = PortfolioItem::where('is_active', true)
            ->orderBy('sort_order')
            ->latest()
            ->get();

        // الحصول على الشهادات للعرض
        $testimonials = Testimonial::where('is_active', true)
            ->orderBy('sort_order')
            ->take(5)
            ->get();

        // الحصول على الخدمات النشطة للعرض في الصفحة الرئيسية
        $services = Service::active()->ordered()->take(6)->get();

        return view('home', compact('featuredPortfolio', 'portfolioItems', 'testimonials', 'services'));
    }
}
