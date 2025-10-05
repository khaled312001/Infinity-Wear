<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * عرض صفحة التقييمات
     */
    public function index()
    {
        // الحصول على جميع التقييمات النشطة مرتبة حسب الترتيب
        $testimonials = Testimonial::where('is_active', true)
            ->orderBy('sort_order')
            ->latest()
            ->paginate(10);

        // حساب متوسط التقييمات
        $averageRating = Testimonial::where('is_active', true)
            ->avg('rating');

        // عدد التقييمات
        $testimonialCount = Testimonial::where('is_active', true)
            ->count();

        return view('testimonials.index', compact('testimonials', 'averageRating', 'testimonialCount'));
    }

    /**
     * عرض نموذج إضافة تقييم جديد
     */
    public function create()
    {
        return view('testimonials.create');
    }

    /**
     * حفظ تقييم جديد من العميل
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'client_position' => 'required|string|max:255',
            'client_company' => 'required|string|max:255',
            'content' => 'required|string|min:10',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $data = [
            'client_name' => $request->client_name,
            'client_position' => $request->client_position,
            'client_company' => $request->client_company,
            'content' => $request->content,
            'rating' => $request->rating,
            'is_active' => false, // يتطلب موافقة المشرف
            'sort_order' => 0,
        ];

        // معالجة الصورة إذا تم تحميلها
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('testimonials', 'public');
        }

        Testimonial::create($data);

        return redirect()->route('testimonials.index')
            ->with('success', 'شكراً لك! تم إرسال شهادتك وستظهر بعد المراجعة.');
    }

    /**
     * الحصول على التقييمات المميزة للعرض في الصفحة الرئيسية (AJAX)
     */
    public function getFeaturedTestimonials()
    {
        $testimonials = Testimonial::where('is_active', true)
            ->orderBy('rating', 'desc')
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        return response()->json([
            'success' => true,
            'testimonials' => $testimonials
        ]);
    }
}