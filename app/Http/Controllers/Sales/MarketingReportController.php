<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\MarketingReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MarketingReportController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $reports = MarketingReport::with('creator')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // إحصائيات التقارير
        $stats = [
            'total' => MarketingReport::count(),
            'pending' => MarketingReport::where('status', 'pending')->count(),
            'approved' => MarketingReport::where('status', 'approved')->count(),
            'rejected' => MarketingReport::where('status', 'rejected')->count(),
            'this_month' => MarketingReport::whereMonth('created_at', now()->month)->count(),
        ];

        // إحصائيات حسب المندوب
        $representativeStats = MarketingReport::selectRaw('representative_name, COUNT(*) as count')
            ->groupBy('representative_name')
            ->orderBy('count', 'desc')
            ->get();

        // إحصائيات حسب حالة الاتفاق
        $agreementStats = MarketingReport::selectRaw('agreement_status, COUNT(*) as count')
            ->groupBy('agreement_status')
            ->get();

        return view('sales.marketing-reports.index', compact(
            'reports', 
            'stats', 
            'representativeStats', 
            'agreementStats'
        ));
    }

    public function create()
    {
        return view('sales.marketing-reports.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'representative_name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'company_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // 10MB max per file
            'company_address' => 'required|string|max:1000',
            'company_activity' => 'required|in:sports_academy,school,institution_company,wholesale_store,retail_store,other',
            'responsible_name' => 'required|string|max:255',
            'responsible_phone' => 'required|string|max:20',
            'responsible_position' => 'required|string|max:255',
            'visit_type' => 'required|in:office_visit,phone_call,whatsapp',
            'agreement_status' => 'required|in:agreed,rejected,needs_time',
            'customer_concerns' => 'nullable|array',
            'customer_concerns.*' => 'string|max:255',
            'target_quantity' => 'required|string|max:255',
            'annual_consumption' => 'required|string|max:255',
            'recommendations' => 'nullable|string|max:2000',
            'next_steps' => 'nullable|string|max:2000',
            'notes' => 'nullable|string|max:1000',
        ]);

        $data = $request->all();
        $data['created_by'] = Auth::id();

        // رفع الصور
        if ($request->hasFile('company_images')) {
            $images = [];
            foreach ($request->file('company_images') as $image) {
                $filename = 'marketing-reports/' . Str::random(40) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public', $filename);
                $images[] = $filename;
            }
            $data['company_images'] = $images;
        }

        // معالجة مخاوف العميل
        if ($request->has('customer_concerns')) {
            $data['customer_concerns'] = array_filter($request->customer_concerns);
        }

        $report = MarketingReport::create($data);

        return redirect()->route('sales.marketing-reports.show', $report)
            ->with('success', 'تم إنشاء تقرير المندوب بنجاح');
    }

    public function show(MarketingReport $marketingReport)
    {
        $marketingReport->load('creator');
        return view('sales.marketing-reports.show', compact('marketingReport'));
    }

    public function edit(MarketingReport $marketingReport)
    {
        return view('sales.marketing-reports.edit', compact('marketingReport'));
    }

    public function update(Request $request, MarketingReport $marketingReport)
    {
        $request->validate([
            'representative_name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'company_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'company_address' => 'required|string|max:1000',
            'company_activity' => 'required|in:sports_academy,school,institution_company,wholesale_store,retail_store,other',
            'responsible_name' => 'required|string|max:255',
            'responsible_phone' => 'required|string|max:20',
            'responsible_position' => 'required|string|max:255',
            'visit_type' => 'required|in:office_visit,phone_call,whatsapp',
            'agreement_status' => 'required|in:agreed,rejected,needs_time',
            'customer_concerns' => 'nullable|array',
            'customer_concerns.*' => 'string|max:255',
            'target_quantity' => 'required|string|max:255',
            'annual_consumption' => 'required|string|max:255',
            'recommendations' => 'nullable|string|max:2000',
            'next_steps' => 'nullable|string|max:2000',
            'notes' => 'nullable|string|max:1000',
            'status' => 'nullable|in:pending,approved,rejected,under_review',
        ]);

        $data = $request->all();

        // رفع الصور الجديدة
        if ($request->hasFile('company_images')) {
            // حذف الصور القديمة
            if ($marketingReport->company_images) {
                foreach ($marketingReport->company_images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }

            $images = [];
            foreach ($request->file('company_images') as $image) {
                $filename = 'marketing-reports/' . Str::random(40) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public', $filename);
                $images[] = $filename;
            }
            $data['company_images'] = $images;
        }

        // معالجة مخاوف العميل
        if ($request->has('customer_concerns')) {
            $data['customer_concerns'] = array_filter($request->customer_concerns);
        }

        $marketingReport->update($data);

        return redirect()->route('sales.marketing-reports.show', $marketingReport)
            ->with('success', 'تم تحديث تقرير المندوب بنجاح');
    }

    public function destroy(MarketingReport $marketingReport)
    {
        // حذف الصور
        if ($marketingReport->company_images) {
            foreach ($marketingReport->company_images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $marketingReport->delete();

        return redirect()->route('sales.marketing-reports.index')
            ->with('success', 'تم حذف تقرير المندوب بنجاح');
    }

    public function updateStatus(Request $request, MarketingReport $marketingReport)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,under_review',
            'notes' => 'nullable|string|max:1000'
        ]);

        $marketingReport->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()->back()->with('success', 'تم تحديث حالة التقرير بنجاح');
    }

    public function export(Request $request)
    {
        $query = MarketingReport::with('creator');

        // فلترة حسب المندوب
        if ($request->has('representative_name') && $request->representative_name) {
            $query->where('representative_name', $request->representative_name);
        }

        // فلترة حسب حالة الاتفاق
        if ($request->has('agreement_status') && $request->agreement_status) {
            $query->where('agreement_status', $request->agreement_status);
        }

        // فلترة حسب نوع الزيارة
        if ($request->has('visit_type') && $request->visit_type) {
            $query->where('visit_type', $request->visit_type);
        }

        // فلترة حسب التاريخ
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $reports = $query->orderBy('created_at', 'desc')->get();

        // هنا يمكن إضافة منطق تصدير إلى Excel أو PDF
        // للآن سنعيد البيانات للعرض

        return view('sales.marketing-reports.export', compact('reports'));
    }
}
