<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Order;
use App\Models\CustomDesign;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    public function __construct()
    {
        // Middleware is applied in routes
    }

    /**
     * عرض لوحة التحكم المالية الرئيسية
     */
    public function dashboard()
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        
        // الإحصائيات الأساسية
        $stats = [
            'monthly_revenue' => Transaction::getMonthlyRevenue(),
            'monthly_expenses' => Transaction::getMonthlyExpenses(),
            'monthly_profit' => Transaction::getMonthlyProfit(),
            'yearly_stats' => Transaction::getYearlyStats()
        ];

        // بيانات الرسم البياني الشهري
        $chartData = Transaction::getMonthlyChartData($currentYear);

        // أحدث المعاملات
        $recentTransactions = Transaction::with('createdBy')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // إحصائيات الفئات
        $incomeCategories = Transaction::getCategoryStats('income');
        $expenseCategories = Transaction::getCategoryStats('expense');

        // المعاملات المعلقة
        $pendingTransactions = Transaction::where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.finance.dashboard', compact(
            'stats',
            'chartData',
            'recentTransactions',
            'incomeCategories',
            'expenseCategories',
            'pendingTransactions'
        ));
    }

    /**
     * عرض جميع المعاملات
     */
    public function transactions(Request $request)
    {
        $query = Transaction::with('createdBy');

        // التصفية حسب النوع
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // التصفية حسب الفئة
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // التصفية حسب الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // التصفية حسب التاريخ
        if ($request->filled('date_from')) {
            $query->whereDate('transaction_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('transaction_date', '<=', $request->date_to);
        }

        // البحث في الوصف
        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $transactions = $query->orderBy('transaction_date', 'desc')
            ->paginate(20);

        // الفئات للتصفية
        $incomeCategories = Transaction::getIncomeCategories();
        $expenseCategories = Transaction::getExpenseCategories();

        return view('admin.finance.transactions', compact(
            'transactions',
            'incomeCategories',
            'expenseCategories'
        ));
    }

    /**
     * إنشاء معاملة جديدة
     */
    public function create()
    {
        $incomeCategories = Transaction::getIncomeCategories();
        $expenseCategories = Transaction::getExpenseCategories();
        $paymentMethods = Transaction::getPaymentMethods();

        return view('admin.finance.create', compact(
            'incomeCategories',
            'expenseCategories',
            'paymentMethods'
        ));
    }

    /**
     * حفظ معاملة جديدة
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:1000',
            'payment_method' => 'nullable|string|max:255',
            'transaction_date' => 'required|date',
            'status' => 'required|in:pending,completed,cancelled',
            'notes' => 'nullable|string|max:2000'
        ]);

        Transaction::create([
            'type' => $request->type,
            'category' => $request->category,
            'amount' => $request->amount,
            'description' => $request->description,
            'payment_method' => $request->payment_method,
            'transaction_date' => $request->transaction_date,
            'status' => $request->status,
            'notes' => $request->notes,
            'created_by' => auth('admin')->id()
        ]);

        return redirect()->route('admin.finance.transactions')
            ->with('success', 'تم إضافة المعاملة بنجاح');
    }

    /**
     * عرض تفاصيل معاملة
     */
    public function show(Transaction $transaction)
    {
        $transaction->load('createdBy');
        
        return view('admin.finance.show', compact('transaction'));
    }

    /**
     * تعديل معاملة
     */
    public function edit(Transaction $transaction)
    {
        $incomeCategories = Transaction::getIncomeCategories();
        $expenseCategories = Transaction::getExpenseCategories();
        $paymentMethods = Transaction::getPaymentMethods();

        return view('admin.finance.edit', compact(
            'transaction',
            'incomeCategories',
            'expenseCategories',
            'paymentMethods'
        ));
    }

    /**
     * تحديث معاملة
     */
    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:1000',
            'payment_method' => 'nullable|string|max:255',
            'transaction_date' => 'required|date',
            'status' => 'required|in:pending,completed,cancelled',
            'notes' => 'nullable|string|max:2000'
        ]);

        $transaction->update([
            'type' => $request->type,
            'category' => $request->category,
            'amount' => $request->amount,
            'description' => $request->description,
            'payment_method' => $request->payment_method,
            'transaction_date' => $request->transaction_date,
            'status' => $request->status,
            'notes' => $request->notes
        ]);

        return redirect()->route('admin.finance.transactions')
            ->with('success', 'تم تحديث المعاملة بنجاح');
    }

    /**
     * حذف معاملة
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->route('admin.finance.transactions')
            ->with('success', 'تم حذف المعاملة بنجاح');
    }

    /**
     * تقارير مالية
     */
    public function reports(Request $request)
    {
        $year = $request->get('year', Carbon::now()->year);
        $month = $request->get('month');

        // إحصائيات السنة
        $yearlyStats = Transaction::getYearlyStats($year);

        // بيانات الرسم البياني
        $chartData = Transaction::getMonthlyChartData($year);

        // تقرير الفئات
        $incomeByCategory = Transaction::getCategoryStats('income', $year);
        $expenseByCategory = Transaction::getCategoryStats('expense', $year);

        // إحصائيات شهرية إذا تم تحديد الشهر
        $monthlyStats = null;
        if ($month) {
            $monthlyStats = [
                'revenue' => Transaction::getMonthlyRevenue($year, $month),
                'expenses' => Transaction::getMonthlyExpenses($year, $month),
                'profit' => Transaction::getMonthlyProfit($year, $month),
                'transactions_count' => Transaction::whereYear('transaction_date', $year)
                    ->whereMonth('transaction_date', $month)
                    ->count()
            ];
        }

        // مقارنة مع السنة السابقة
        $previousYearStats = Transaction::getYearlyStats($year - 1);
        $growth = [
            'revenue' => $previousYearStats['revenue'] > 0 ? 
                (($yearlyStats['revenue'] - $previousYearStats['revenue']) / $previousYearStats['revenue']) * 100 : 0,
            'expenses' => $previousYearStats['expenses'] > 0 ? 
                (($yearlyStats['expenses'] - $previousYearStats['expenses']) / $previousYearStats['expenses']) * 100 : 0,
            'profit' => $previousYearStats['profit'] != 0 ? 
                (($yearlyStats['profit'] - $previousYearStats['profit']) / abs($previousYearStats['profit'])) * 100 : 0
        ];

        return view('admin.finance.reports', compact(
            'year',
            'month',
            'yearlyStats',
            'chartData',
            'incomeByCategory',
            'expenseByCategory',
            'monthlyStats',
            'previousYearStats',
            'growth'
        ));
    }

    /**
     * تصدير التقارير
     */
    public function export(Request $request)
    {
        $type = $request->get('type', 'excel'); // excel, pdf, csv
        $year = $request->get('year', Carbon::now()->year);
        
        // جلب البيانات
        $transactions = Transaction::whereYear('transaction_date', $year)
            ->orderBy('transaction_date', 'desc')
            ->get();

        $stats = Transaction::getYearlyStats($year);
        
        if ($type === 'csv') {
            return $this->exportCSV($transactions, $year);
        }
        
        // يمكن إضافة تصدير Excel و PDF لاحقاً
        return redirect()->back()->with('info', 'سيتم إضافة تصدير Excel و PDF قريباً');
    }

    /**
     * تصدير CSV
     */
    private function exportCSV($transactions, $year)
    {
        $filename = "transactions_{$year}.csv";
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($transactions) {
            $file = fopen('php://output', 'w');
            
            // إضافة BOM لدعم UTF-8 في Excel
            fputs($file, "\xEF\xBB\xBF");
            
            // رؤوس الأعمدة
            fputcsv($file, [
                'التاريخ',
                'النوع',
                'الفئة',
                'المبلغ',
                'الوصف',
                'طريقة الدفع',
                'الحالة'
            ]);

            // البيانات
            foreach ($transactions as $transaction) {
                fputcsv($file, [
                    $transaction->transaction_date->format('Y-m-d'),
                    $transaction->type === 'income' ? 'إيراد' : 'مصروف',
                    $transaction->category,
                    $transaction->amount,
                    $transaction->description,
                    $transaction->payment_method ?? '-',
                    $transaction->status === 'completed' ? 'مكتملة' : 
                        ($transaction->status === 'pending' ? 'معلقة' : 'ملغية')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * إحصائيات سريعة للـ API
     */
    public function quickStats()
    {
        $today = Carbon::today();
        $thisWeek = Carbon::now()->startOfWeek();
        $thisMonth = Carbon::now()->startOfMonth();

        $stats = [
            'today' => [
                'revenue' => Transaction::income()->completed()
                    ->whereDate('transaction_date', $today)->sum('amount'),
                'expenses' => Transaction::expense()->completed()
                    ->whereDate('transaction_date', $today)->sum('amount'),
            ],
            'this_week' => [
                'revenue' => Transaction::income()->completed()
                    ->where('transaction_date', '>=', $thisWeek)->sum('amount'),
                'expenses' => Transaction::expense()->completed()
                    ->where('transaction_date', '>=', $thisWeek)->sum('amount'),
            ],
            'this_month' => [
                'revenue' => Transaction::getMonthlyRevenue(),
                'expenses' => Transaction::getMonthlyExpenses(),
            ]
        ];

        // حساب الأرباح
        foreach ($stats as &$period) {
            $period['profit'] = $period['revenue'] - $period['expenses'];
        }

        return response()->json($stats);
    }
}