<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', // 'income' or 'expense'
        'category',
        'amount',
        'description',
        'reference_id',
        'reference_type', // 'order', 'custom_design', 'general'
        'payment_method',
        'transaction_date',
        'status', // 'pending', 'completed', 'cancelled'
        'created_by',
        'notes'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'transaction_date' => 'datetime',
    ];

    // العلاقات
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'reference_id')->where('reference_type', 'order');
    }

    public function customDesign()
    {
        return $this->belongsTo(CustomDesign::class, 'reference_id')->where('reference_type', 'custom_design');
    }

    // النطاقات (Scopes)
    public function scopeIncome($query)
    {
        return $query->where('type', 'income');
    }

    public function scopeExpense($query)
    {
        return $query->where('type', 'expense');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('transaction_date', Carbon::now()->month)
                    ->whereYear('transaction_date', Carbon::now()->year);
    }

    public function scopeThisYear($query)
    {
        return $query->whereYear('transaction_date', Carbon::now()->year);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // الحصول على الإيرادات الشهرية
    public static function getMonthlyRevenue($year = null, $month = null)
    {
        $year = $year ?? Carbon::now()->year;
        $month = $month ?? Carbon::now()->month;

        return self::income()
                   ->completed()
                   ->whereYear('transaction_date', $year)
                   ->whereMonth('transaction_date', $month)
                   ->sum('amount');
    }

    // الحصول على المصروفات الشهرية
    public static function getMonthlyExpenses($year = null, $month = null)
    {
        $year = $year ?? Carbon::now()->year;
        $month = $month ?? Carbon::now()->month;

        return self::expense()
                   ->completed()
                   ->whereYear('transaction_date', $year)
                   ->whereMonth('transaction_date', $month)
                   ->sum('amount');
    }

    // الحصول على صافي الربح الشهري
    public static function getMonthlyProfit($year = null, $month = null)
    {
        $revenue = self::getMonthlyRevenue($year, $month);
        $expenses = self::getMonthlyExpenses($year, $month);
        
        return $revenue - $expenses;
    }

    // الحصول على إحصائيات سنوية
    public static function getYearlyStats($year = null)
    {
        $year = $year ?? Carbon::now()->year;

        $revenue = self::income()
                       ->completed()
                       ->whereYear('transaction_date', $year)
                       ->sum('amount');

        $expenses = self::expense()
                        ->completed()
                        ->whereYear('transaction_date', $year)
                        ->sum('amount');

        return [
            'revenue' => $revenue,
            'expenses' => $expenses,
            'profit' => $revenue - $expenses,
            'transactions_count' => self::whereYear('transaction_date', $year)->count()
        ];
    }

    // الحصول على إحصائيات حسب الفئة
    public static function getCategoryStats($type = 'income', $year = null)
    {
        $year = $year ?? Carbon::now()->year;

        return self::where('type', $type)
                   ->completed()
                   ->whereYear('transaction_date', $year)
                   ->selectRaw('category, SUM(amount) as total, COUNT(*) as count')
                   ->groupBy('category')
                   ->orderBy('total', 'desc')
                   ->get();
    }

    // الحصول على البيانات الشهرية للرسم البياني
    public static function getMonthlyChartData($year = null)
    {
        $year = $year ?? Carbon::now()->year;
        
        $data = [];
        
        for ($month = 1; $month <= 12; $month++) {
            $revenue = self::getMonthlyRevenue($year, $month);
            $expenses = self::getMonthlyExpenses($year, $month);
            
            $data[] = [
                'month' => $month,
                'month_name' => Carbon::create($year, $month)->format('M'),
                'month_name_ar' => self::getArabicMonthName($month),
                'revenue' => $revenue,
                'expenses' => $expenses,
                'profit' => $revenue - $expenses
            ];
        }
        
        return $data;
    }

    private static function getArabicMonthName($month)
    {
        $months = [
            1 => 'يناير', 2 => 'فبراير', 3 => 'مارس', 4 => 'أبريل',
            5 => 'مايو', 6 => 'يونيو', 7 => 'يوليو', 8 => 'أغسطس',
            9 => 'سبتمبر', 10 => 'أكتوبر', 11 => 'نوفمبر', 12 => 'ديسمبر'
        ];
        
        return $months[$month];
    }

    // فئات الإيرادات
    public static function getIncomeCategories()
    {
        return [
            'orders' => 'مبيعات الطلبات',
            'custom_designs' => 'التصاميم المخصصة',
            'consultation' => 'استشارات التصميم',
            'rush_orders' => 'طلبات عاجلة',
            'bulk_discount' => 'خصومات الكميات الكبيرة',
            'other' => 'أخرى'
        ];
    }

    // فئات المصروفات
    public static function getExpenseCategories()
    {
        return [
            'materials' => 'المواد الخام',
            'manufacturing' => 'التصنيع',
            'shipping' => 'الشحن والتوصيل',
            'marketing' => 'التسويق والإعلان',
            'salaries' => 'الرواتب',
            'rent' => 'الإيجار',
            'utilities' => 'المرافق',
            'equipment' => 'المعدات',
            'maintenance' => 'الصيانة',
            'insurance' => 'التأمين',
            'taxes' => 'الضرائب',
            'other' => 'أخرى'
        ];
    }

    // طرق الدفع
    public static function getPaymentMethods()
    {
        return [
            'cash' => 'نقداً',
            'bank_transfer' => 'حوالة بنكية',
            'credit_card' => 'بطاقة ائتمان',
            'mada' => 'مدى',
            'stc_pay' => 'STC Pay',
            'paypal' => 'PayPal',
            'other' => 'أخرى'
        ];
    }

    // إنشاء معاملة من طلب
    public static function createFromOrder(Order $order)
    {
        return self::create([
            'type' => 'income',
            'category' => 'orders',
            'amount' => $order->total_amount,
            'description' => "إيراد من الطلب رقم #{$order->id}",
            'reference_id' => $order->id,
            'reference_type' => 'order',
            'transaction_date' => now(),
            'status' => 'completed',
            'created_by' => auth('admin')->id()
        ]);
    }

    // إنشاء معاملة من تصميم مخصص
    public static function createFromCustomDesign(CustomDesign $design, $amount)
    {
        return self::create([
            'type' => 'income',
            'category' => 'custom_designs',
            'amount' => $amount,
            'description' => "إيراد من التصميم المخصص: {$design->name}",
            'reference_id' => $design->id,
            'reference_type' => 'custom_design',
            'transaction_date' => now(),
            'status' => 'completed',
            'created_by' => auth('admin')->id()
        ]);
    }
}