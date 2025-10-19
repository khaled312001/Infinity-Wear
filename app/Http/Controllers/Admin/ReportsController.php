<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Importer;
use App\Models\TaskCard;
use App\Models\Transaction;
use App\Models\ImporterOrder;
use App\Models\MarketingReport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportsController extends Controller
{
    /**
     * عرض صفحة التقارير الرئيسية
     */
    public function index(Request $request)
    {
        $period = $request->get('period', 'month');
        $startDate = $this->getStartDate($period);
        $endDate = Carbon::now();

        // إحصائيات عامة
        $stats = $this->getGeneralStats($startDate, $endDate);

        // إحصائيات المبيعات الشهرية
        $monthlySales = $this->getMonthlySales($startDate, $endDate);

        // إحصائيات المستوردين حسب الحالة
        $importersByStatus = $this->getImportersByStatus();

        // إحصائيات المهام حسب القسم
        $tasksByDepartment = $this->getTasksByDepartment($startDate, $endDate);

        // أداء فريق المبيعات
        $salesPerformance = $this->getSalesPerformance($startDate, $endDate);

        // أداء فريق التسويق
        $marketingPerformance = $this->getMarketingPerformance($startDate, $endDate);

        // إحصائيات المعاملات المالية
        $financialStats = $this->getFinancialStats($startDate, $endDate);

        return view('admin.reports', compact(
            'stats',
            'monthlySales',
            'importersByStatus',
            'tasksByDepartment',
            'salesPerformance',
            'marketingPerformance',
            'financialStats',
            'period',
            'startDate',
            'endDate'
        ));
    }

    /**
     * تصدير التقرير بصيغة Excel
     */
    public function exportExcel(Request $request)
    {
        $period = $request->get('period', 'month');
        $startDate = $this->getStartDate($period);
        $endDate = Carbon::now();

        // جلب البيانات
        $data = $this->getExportData($startDate, $endDate);

        $filename = "reports_" . $period . "_" . date('Y-m-d') . ".xlsx";

        return Excel::download(new \App\Exports\ReportsExport($data), $filename);
    }

    /**
     * تصدير التقرير بصيغة PDF
     */
    public function exportPdf(Request $request)
    {
        $period = $request->get('period', 'month');
        $startDate = $this->getStartDate($period);
        $endDate = Carbon::now();

        // جلب البيانات
        $data = $this->getExportData($startDate, $endDate);

        $pdf = Pdf::loadView('admin.reports.export-pdf', compact('data', 'period', 'startDate', 'endDate'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download("reports_" . $period . "_" . date('Y-m-d') . ".pdf");
    }

    /**
     * الحصول على تاريخ البداية حسب الفترة
     */
    private function getStartDate($period)
    {
        switch ($period) {
            case 'today':
                return Carbon::today();
            case 'week':
                return Carbon::now()->subWeek();
            case 'month':
                return Carbon::now()->subMonth();
            case 'quarter':
                return Carbon::now()->subQuarter();
            case 'year':
                return Carbon::now()->subYear();
            default:
                return Carbon::now()->subMonth();
        }
    }

    /**
     * الحصول على الإحصائيات العامة
     */
    private function getGeneralStats($startDate, $endDate)
    {
        return [
            'total_users' => User::count(),
            'total_importers' => Importer::count(),
            'total_tasks' => TaskCard::count(),
            'total_transactions' => Transaction::count(),
            'total_importer_orders' => ImporterOrder::count(),
            'total_marketing_reports' => MarketingReport::count(),
            'pending_marketing_reports' => MarketingReport::where('status', 'pending')->count(),
            'approved_marketing_reports' => MarketingReport::where('status', 'approved')->count(),
        ];
    }

    /**
     * الحصول على إحصائيات المبيعات الشهرية
     */
    private function getMonthlySales($startDate, $endDate)
    {
        return ImporterOrder::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(amount) as total_amount')
        )
        ->whereBetween('created_at', [$startDate, $endDate])
        ->groupBy('month', 'year')
        ->orderBy('year')
        ->orderBy('month')
        ->get();
    }

    /**
     * الحصول على إحصائيات المستوردين حسب الحالة
     */
    private function getImportersByStatus()
    {
        return Importer::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
    }

    /**
     * الحصول على إحصائيات المهام حسب القسم
     */
    private function getTasksByDepartment($startDate, $endDate)
    {
        return TaskCard::select('department', DB::raw('COUNT(*) as total'), DB::raw('SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('department')
            ->get();
    }

    /**
     * الحصول على أداء فريق المبيعات
     */
    private function getSalesPerformance($startDate, $endDate)
    {
        return DB::table('importers')
            ->join('admins', 'importers.created_by', '=', 'admins.id')
            ->select(
                'admins.name',
                'admins.id',
                DB::raw('COUNT(importers.id) as total_importers'),
                DB::raw('SUM(CASE WHEN importers.status = "approved" THEN 1 ELSE 0 END) as won_deals')
            )
            ->whereBetween('importers.created_at', [$startDate, $endDate])
            ->groupBy('admins.id', 'admins.name')
            ->get();
    }

    /**
     * الحصول على أداء فريق التسويق
     */
    private function getMarketingPerformance($startDate, $endDate)
    {
        return DB::table('task_cards')
            ->join('admins', 'task_cards.assigned_to', '=', 'admins.id')
            ->select(
                'admins.name',
                'admins.id',
                DB::raw('COUNT(task_cards.id) as total_tasks'),
                DB::raw('SUM(CASE WHEN task_cards.status = "completed" THEN 1 ELSE 0 END) as completed_tasks')
            )
            ->where('task_cards.department', 'marketing')
            ->whereBetween('task_cards.created_at', [$startDate, $endDate])
            ->groupBy('admins.id', 'admins.name')
            ->get();
    }

    /**
     * الحصول على الإحصائيات المالية
     */
    private function getFinancialStats($startDate, $endDate)
    {
        return [
            'total_income' => Transaction::where('type', 'income')
                ->whereBetween('transaction_date', [$startDate, $endDate])
                ->sum('amount'),
            'total_expenses' => Transaction::where('type', 'expense')
                ->whereBetween('transaction_date', [$startDate, $endDate])
                ->sum('amount'),
            'net_profit' => Transaction::where('type', 'income')
                ->whereBetween('transaction_date', [$startDate, $endDate])
                ->sum('amount') - Transaction::where('type', 'expense')
                ->whereBetween('transaction_date', [$startDate, $endDate])
                ->sum('amount'),
        ];
    }

    /**
     * الحصول على بيانات التصدير
     */
    private function getExportData($startDate, $endDate)
    {
        return [
            'general_stats' => $this->getGeneralStats($startDate, $endDate),
            'monthly_sales' => $this->getMonthlySales($startDate, $endDate),
            'importers_by_status' => $this->getImportersByStatus(),
            'tasks_by_department' => $this->getTasksByDepartment($startDate, $endDate),
            'sales_performance' => $this->getSalesPerformance($startDate, $endDate),
            'marketing_performance' => $this->getMarketingPerformance($startDate, $endDate),
            'financial_stats' => $this->getFinancialStats($startDate, $endDate),
        ];
    }
}
