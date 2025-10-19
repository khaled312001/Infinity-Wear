<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MarketingReport;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MarketingReportController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * عرض قائمة تقارير المندوبين التسويقيين
     */
    public function index()
    {
        $reports = MarketingReport::with('creator')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // إحصائيات شاملة
        $stats = [
            'total' => MarketingReport::count(),
            'pending' => MarketingReport::where('status', 'pending')->count(),
            'approved' => MarketingReport::where('status', 'approved')->count(),
            'rejected' => MarketingReport::where('status', 'rejected')->count(),
            'under_review' => MarketingReport::where('status', 'under_review')->count(),
            'this_month' => MarketingReport::whereMonth('created_at', now()->month)->count(),
            'this_week' => MarketingReport::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'today' => MarketingReport::whereDate('created_at', today())->count(),
        ];

        // إحصائيات المندوبين
        $representativeStats = MarketingReport::selectRaw('representative_name, COUNT(*) as count')
            ->groupBy('representative_name')
            ->orderBy('count', 'desc')
            ->get();

        // إحصائيات حالة الاتفاق
        $agreementStats = MarketingReport::selectRaw('agreement_status, COUNT(*) as count')
            ->groupBy('agreement_status')
            ->get();

        // إحصائيات نوع الزيارة
        $visitTypeStats = MarketingReport::selectRaw('visit_type, COUNT(*) as count')
            ->groupBy('visit_type')
            ->get();

        // إحصائيات نوع النشاط
        $activityStats = MarketingReport::selectRaw('company_activity, COUNT(*) as count')
            ->groupBy('company_activity')
            ->get();

        // إحصائيات شهرية للآخر 6 أشهر
        $monthlyStats = MarketingReport::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        // إحصائيات المبيعات المحتملة
        $salesStats = [
            'total_target_quantity' => MarketingReport::sum('target_quantity'),
            'total_annual_consumption' => MarketingReport::sum('annual_consumption'),
            'avg_target_quantity' => MarketingReport::avg('target_quantity'),
            'avg_annual_consumption' => MarketingReport::avg('annual_consumption'),
        ];

        // تقارير تحتاج مراجعة
        $reportsNeedingReview = MarketingReport::where('status', 'pending')
            ->orWhere('status', 'under_review')
            ->with('creator')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.marketing-reports.index', compact(
            'reports',
            'stats',
            'representativeStats',
            'agreementStats',
            'visitTypeStats',
            'activityStats',
            'monthlyStats',
            'salesStats',
            'reportsNeedingReview'
        ));
    }

    /**
     * عرض تفاصيل تقرير معين
     */
    public function show(MarketingReport $marketingReport)
    {
        $marketingReport->load('creator');
        
        return view('admin.marketing-reports.show', compact('marketingReport'));
    }

    /**
     * تحديث حالة التقرير
     */
    public function updateStatus(Request $request, MarketingReport $marketingReport)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,under_review',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $marketingReport->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'reviewed_by' => Auth::guard('admin')->id(),
            'reviewed_at' => now(),
        ]);

        return redirect()->back()->with('success', 'تم تحديث حالة التقرير بنجاح');
    }

    /**
     * حذف تقرير
     */
    public function destroy(MarketingReport $marketingReport)
    {
        $marketingReport->delete();
        
        return redirect()->route('admin.marketing-reports.index')
            ->with('success', 'تم حذف التقرير بنجاح');
    }

    /**
     * تصدير التقارير
     */
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

        return view('admin.marketing-reports.export', compact('reports'));
    }

    /**
     * إحصائيات مفصلة
     */
    public function analytics()
    {
        // إحصائيات الأداء الشهري
        $monthlyPerformance = MarketingReport::selectRaw('
            YEAR(created_at) as year,
            MONTH(created_at) as month,
            COUNT(*) as total_reports,
            SUM(CASE WHEN status = "approved" THEN 1 ELSE 0 END) as approved_reports,
            SUM(CASE WHEN agreement_status = "agreed" THEN 1 ELSE 0 END) as agreed_reports,
            AVG(target_quantity) as avg_target_quantity,
            AVG(annual_consumption) as avg_annual_consumption
        ')
        ->where('created_at', '>=', now()->subMonths(12))
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->get();

        // أداء المندوبين
        $representativePerformance = MarketingReport::selectRaw('
            representative_name,
            COUNT(*) as total_reports,
            SUM(CASE WHEN status = "approved" THEN 1 ELSE 0 END) as approved_reports,
            SUM(CASE WHEN agreement_status = "agreed" THEN 1 ELSE 0 END) as agreed_reports,
            AVG(target_quantity) as avg_target_quantity,
            SUM(target_quantity) as total_target_quantity,
            AVG(annual_consumption) as avg_annual_consumption,
            SUM(annual_consumption) as total_annual_consumption
        ')
        ->groupBy('representative_name')
        ->orderBy('total_reports', 'desc')
        ->get();

        // إحصائيات حسب نوع النشاط
        $activityPerformance = MarketingReport::selectRaw('
            company_activity,
            COUNT(*) as total_reports,
            SUM(CASE WHEN agreement_status = "agreed" THEN 1 ELSE 0 END) as agreed_reports,
            AVG(target_quantity) as avg_target_quantity,
            AVG(annual_consumption) as avg_annual_consumption
        ')
        ->groupBy('company_activity')
        ->orderBy('total_reports', 'desc')
        ->get();

        // إحصائيات الاتفاق حسب نوع الزيارة
        $visitTypeAgreement = MarketingReport::selectRaw('
            visit_type,
            COUNT(*) as total_reports,
            SUM(CASE WHEN agreement_status = "agreed" THEN 1 ELSE 0 END) as agreed_reports,
            SUM(CASE WHEN agreement_status = "rejected" THEN 1 ELSE 0 END) as rejected_reports,
            SUM(CASE WHEN agreement_status = "needs_time" THEN 1 ELSE 0 END) as needs_time_reports
        ')
        ->groupBy('visit_type')
        ->get();

        return view('admin.marketing-reports.analytics', compact(
            'monthlyPerformance',
            'representativePerformance',
            'activityPerformance',
            'visitTypeAgreement'
        ));
    }

    /**
     * تحديث التقرير
     */
    public function edit(MarketingReport $marketingReport)
    {
        $marketingReport->load('creator');
        
        return view('admin.marketing-reports.edit', compact('marketingReport'));
    }

    /**
     * حفظ تحديثات التقرير
     */
    public function update(Request $request, MarketingReport $marketingReport)
    {
        $request->validate([
            'representative_name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string|max:500',
            'company_activity' => 'required|string|in:sports_academy,school,institution_company,wholesale_store,retail_store,other',
            'responsible_name' => 'required|string|max:255',
            'responsible_phone' => 'required|string|max:20',
            'responsible_position' => 'required|string|max:255',
            'visit_type' => 'required|string|in:office_visit,phone_call,whatsapp',
            'agreement_status' => 'required|string|in:agreed,rejected,needs_time',
            'target_quantity' => 'required|integer|min:0',
            'annual_consumption' => 'required|integer|min:0',
            'recommendations' => 'required|string|max:1000',
            'next_steps' => 'required|string|max:1000',
            'status' => 'required|string|in:pending,approved,rejected,under_review',
            'notes' => 'nullable|string|max:1000',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $marketingReport->update([
            'representative_name' => $request->representative_name,
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'company_activity' => $request->company_activity,
            'responsible_name' => $request->responsible_name,
            'responsible_phone' => $request->responsible_phone,
            'responsible_position' => $request->responsible_position,
            'visit_type' => $request->visit_type,
            'agreement_status' => $request->agreement_status,
            'target_quantity' => $request->target_quantity,
            'annual_consumption' => $request->annual_consumption,
            'recommendations' => $request->recommendations,
            'next_steps' => $request->next_steps,
            'status' => $request->status,
            'notes' => $request->notes,
            'admin_notes' => $request->admin_notes,
            'reviewed_by' => Auth::guard('admin')->id(),
            'reviewed_at' => now(),
        ]);

        // إرسال إشعار عند تحديث التقرير
        $this->sendMarketingReportNotification($marketingReport, 'updated');

        return redirect()->route('admin.marketing-reports.show', $marketingReport)
            ->with('success', 'تم تحديث التقرير بنجاح');
    }

    /**
     * إرسال إشعار للتقرير التسويقي
     */
    private function sendMarketingReportNotification(MarketingReport $report, $action = 'updated')
    {
        try {
            $title = $action === 'updated' ? 'تقرير تسويقي محدث' : 'تقرير تسويقي جديد';
            $message = $action === 'updated' 
                ? "تم تحديث التقرير التسويقي: {$report->company_name}"
                : "تقرير تسويقي جديد من: {$report->representative_name}";

            $this->notificationService->sendAdvancedNotification(
                'marketing',
                $title,
                $message,
                [
                    'report_id' => $report->id,
                    'company_name' => $report->company_name,
                    'representative_name' => $report->representative_name,
                    'status' => $report->status,
                    'agreement_status' => $report->agreement_status,
                    'target_quantity' => $report->target_quantity,
                    'action' => $action
                ],
                null, // إرسال لجميع المدراء
                'admin'
            );
        } catch (\Exception $e) {
            \Log::error('Failed to send marketing report notification: ' . $e->getMessage());
        }
    }
}
