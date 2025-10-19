<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportsExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths, WithTitle
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $exportData = [];

        // إحصائيات عامة
        $exportData[] = ['الإحصائيات العامة', '', '', ''];
        $exportData[] = ['إجمالي المستخدمين', $this->data['general_stats']['total_users'], '', ''];
        $exportData[] = ['إجمالي المستوردين', $this->data['general_stats']['total_importers'], '', ''];
        $exportData[] = ['إجمالي المهام', $this->data['general_stats']['total_tasks'], '', ''];
        $exportData[] = ['إجمالي المعاملات', $this->data['general_stats']['total_transactions'], '', ''];
        $exportData[] = ['إجمالي طلبات المستوردين', $this->data['general_stats']['total_importer_orders'], '', ''];
        $exportData[] = ['إجمالي تقارير التسويق', $this->data['general_stats']['total_marketing_reports'], '', ''];
        $exportData[] = ['تقارير التسويق المعلقة', $this->data['general_stats']['pending_marketing_reports'], '', ''];
        $exportData[] = ['تقارير التسويق المعتمدة', $this->data['general_stats']['approved_marketing_reports'], '', ''];
        $exportData[] = ['', '', '', ''];

        // إحصائيات المبيعات الشهرية
        $exportData[] = ['المبيعات الشهرية', '', '', ''];
        $exportData[] = ['الشهر', 'السنة', 'عدد الطلبات', 'إجمالي المبلغ'];
        foreach ($this->data['monthly_sales'] as $sale) {
            $exportData[] = [
                $sale->month,
                $sale->year,
                $sale->total,
                number_format($sale->total_amount, 2) . ' ريال'
            ];
        }
        $exportData[] = ['', '', '', ''];

        // إحصائيات المستوردين حسب الحالة
        $exportData[] = ['المستوردين حسب الحالة', '', '', ''];
        $exportData[] = ['الحالة', 'العدد', '', ''];
        foreach ($this->data['importers_by_status'] as $status => $count) {
            $exportData[] = [ucfirst($status), $count, '', ''];
        }
        $exportData[] = ['', '', '', ''];

        // إحصائيات المهام حسب القسم
        $exportData[] = ['المهام حسب القسم', '', '', ''];
        $exportData[] = ['القسم', 'إجمالي المهام', 'المكتملة', 'معدل الإنجاز %'];
        foreach ($this->data['tasks_by_department'] as $department) {
            $percentage = $department->total > 0 ? round(($department->completed / $department->total) * 100, 1) : 0;
            $exportData[] = [
                ucfirst($department->department),
                $department->total,
                $department->completed,
                $percentage
            ];
        }
        $exportData[] = ['', '', '', ''];

        // أداء فريق المبيعات
        $exportData[] = ['أداء فريق المبيعات', '', '', ''];
        $exportData[] = ['المندوب', 'إجمالي العملاء', 'الصفقات المربحة', 'معدل النجاح %'];
        foreach ($this->data['sales_performance'] as $performance) {
            $successRate = $performance->total_importers > 0 ? 
                round(($performance->won_deals / $performance->total_importers) * 100, 1) : 0;
            $exportData[] = [
                $performance->name,
                $performance->total_importers,
                $performance->won_deals,
                $successRate
            ];
        }
        $exportData[] = ['', '', '', ''];

        // أداء فريق التسويق
        $exportData[] = ['أداء فريق التسويق', '', '', ''];
        $exportData[] = ['المندوب', 'إجمالي المهام', 'المكتملة', 'معدل الإنجاز %'];
        foreach ($this->data['marketing_performance'] as $performance) {
            $completionRate = $performance->total_tasks > 0 ? 
                round(($performance->completed_tasks / $performance->total_tasks) * 100, 1) : 0;
            $exportData[] = [
                $performance->name,
                $performance->total_tasks,
                $performance->completed_tasks,
                $completionRate
            ];
        }
        $exportData[] = ['', '', '', ''];

        // الإحصائيات المالية
        $exportData[] = ['الإحصائيات المالية', '', '', ''];
        $exportData[] = ['إجمالي الإيرادات', number_format($this->data['financial_stats']['total_income'], 2) . ' ريال', '', ''];
        $exportData[] = ['إجمالي المصروفات', number_format($this->data['financial_stats']['total_expenses'], 2) . ' ريال', '', ''];
        $exportData[] = ['صافي الربح', number_format($this->data['financial_stats']['net_profit'], 2) . ' ريال', '', ''];

        return $exportData;
    }

    public function headings(): array
    {
        return [
            'التقرير',
            'القيمة',
            'ملاحظات',
            'تاريخ التصدير: ' . date('Y-m-d H:i:s')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true]],
            // Style the headers
            2 => ['font' => ['bold' => true, 'size' => 14]],
            // Style the section headers
            'A:A' => ['font' => ['bold' => true]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 20,
            'C' => 20,
            'D' => 20,
        ];
    }

    public function title(): string
    {
        return 'التقارير والإحصائيات';
    }
}
