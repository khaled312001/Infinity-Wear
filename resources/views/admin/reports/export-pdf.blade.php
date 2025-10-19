<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تقرير شامل - Infinity Wear</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            direction: rtl;
            text-align: right;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }
        
        .header p {
            margin: 10px 0 0 0;
            font-size: 16px;
            opacity: 0.9;
        }
        
        .section {
            background: white;
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .section-title {
            color: #2d3748;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e2e8f0;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .stat-card {
            background: #f7fafc;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #4299e1;
        }
        
        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #2d3748;
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #718096;
            font-size: 14px;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        .table th,
        .table td {
            padding: 12px;
            text-align: right;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .table th {
            background-color: #f7fafc;
            font-weight: bold;
            color: #2d3748;
        }
        
        .table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .progress-bar {
            background-color: #e2e8f0;
            border-radius: 10px;
            height: 20px;
            overflow: hidden;
            margin-top: 5px;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #48bb78, #38a169);
            border-radius: 10px;
            transition: width 0.3s ease;
        }
        
        .footer {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            color: #718096;
            font-size: 12px;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .highlight {
            background-color: #fef5e7;
            padding: 2px 6px;
            border-radius: 4px;
        }
        
        .success {
            color: #38a169;
            font-weight: bold;
        }
        
        .warning {
            color: #d69e2e;
            font-weight: bold;
        }
        
        .danger {
            color: #e53e3e;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>تقرير شامل - Infinity Wear</h1>
        <p>فترة التقرير: {{ $startDate->format('Y-m-d') }} إلى {{ $endDate->format('Y-m-d') }}</p>
        <p>تاريخ التصدير: {{ now()->format('Y-m-d H:i:s') }}</p>
    </div>

    <!-- الإحصائيات العامة -->
    <div class="section">
        <h2 class="section-title">الإحصائيات العامة</h2>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value">{{ number_format($data['general_stats']['total_users']) }}</div>
                <div class="stat-label">إجمالي المستخدمين</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ number_format($data['general_stats']['total_importers']) }}</div>
                <div class="stat-label">إجمالي المستوردين</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ number_format($data['general_stats']['total_tasks']) }}</div>
                <div class="stat-label">إجمالي المهام</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ number_format($data['general_stats']['total_transactions']) }}</div>
                <div class="stat-label">إجمالي المعاملات</div>
            </div>
        </div>
    </div>

    <!-- المبيعات الشهرية -->
    <div class="section">
        <h2 class="section-title">المبيعات الشهرية</h2>
        @if($data['monthly_sales']->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>الشهر</th>
                        <th>السنة</th>
                        <th>عدد الطلبات</th>
                        <th>إجمالي المبلغ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['monthly_sales'] as $sale)
                        <tr>
                            <td>{{ $sale->month }}</td>
                            <td>{{ $sale->year }}</td>
                            <td>{{ $sale->total }}</td>
                            <td>{{ number_format($sale->total_amount, 2) }} ريال</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>لا توجد بيانات مبيعات متاحة</p>
        @endif
    </div>

    <!-- المستوردين حسب الحالة -->
    <div class="section">
        <h2 class="section-title">توزيع المستوردين حسب الحالة</h2>
        @if(count($data['importers_by_status']) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>الحالة</th>
                        <th>العدد</th>
                        <th>النسبة المئوية</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalImporters = array_sum($data['importers_by_status']);
                    @endphp
                    @foreach($data['importers_by_status'] as $status => $count)
                        <tr>
                            <td>{{ ucfirst($status) }}</td>
                            <td>{{ $count }}</td>
                            <td>{{ $totalImporters > 0 ? round(($count / $totalImporters) * 100, 1) : 0 }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>لا توجد بيانات مستوردين متاحة</p>
        @endif
    </div>

    <!-- المهام حسب القسم -->
    <div class="section">
        <h2 class="section-title">أداء الأقسام</h2>
        @if($data['tasks_by_department']->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>القسم</th>
                        <th>إجمالي المهام</th>
                        <th>المكتملة</th>
                        <th>معدل الإنجاز</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['tasks_by_department'] as $department)
                        @php
                            $percentage = $department->total > 0 ? round(($department->completed / $department->total) * 100, 1) : 0;
                        @endphp
                        <tr>
                            <td>{{ ucfirst($department->department) }}</td>
                            <td>{{ $department->total }}</td>
                            <td class="success">{{ $department->completed }}</td>
                            <td>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: {{ $percentage }}%"></div>
                                </div>
                                <span class="{{ $percentage >= 80 ? 'success' : ($percentage >= 60 ? 'warning' : 'danger') }}">
                                    {{ $percentage }}%
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>لا توجد بيانات مهام متاحة</p>
        @endif
    </div>

    <!-- أداء فريق المبيعات -->
    <div class="section">
        <h2 class="section-title">أداء فريق المبيعات</h2>
        @if($data['sales_performance']->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>المندوب</th>
                        <th>إجمالي العملاء</th>
                        <th>الصفقات المربحة</th>
                        <th>معدل النجاح</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['sales_performance'] as $performance)
                        @php
                            $successRate = $performance->total_importers > 0 ? 
                                round(($performance->won_deals / $performance->total_importers) * 100, 1) : 0;
                        @endphp
                        <tr>
                            <td>{{ $performance->name }}</td>
                            <td>{{ $performance->total_importers }}</td>
                            <td class="success">{{ $performance->won_deals }}</td>
                            <td class="{{ $successRate >= 70 ? 'success' : ($successRate >= 50 ? 'warning' : 'danger') }}">
                                {{ $successRate }}%
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>لا توجد بيانات أداء مبيعات متاحة</p>
        @endif
    </div>

    <!-- أداء فريق التسويق -->
    <div class="section">
        <h2 class="section-title">أداء فريق التسويق</h2>
        @if($data['marketing_performance']->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>المندوب</th>
                        <th>إجمالي المهام</th>
                        <th>المكتملة</th>
                        <th>معدل الإنجاز</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['marketing_performance'] as $performance)
                        @php
                            $completionRate = $performance->total_tasks > 0 ? 
                                round(($performance->completed_tasks / $performance->total_tasks) * 100, 1) : 0;
                        @endphp
                        <tr>
                            <td>{{ $performance->name }}</td>
                            <td>{{ $performance->total_tasks }}</td>
                            <td class="success">{{ $performance->completed_tasks }}</td>
                            <td class="{{ $completionRate >= 80 ? 'success' : ($completionRate >= 60 ? 'warning' : 'danger') }}">
                                {{ $completionRate }}%
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>لا توجد بيانات أداء تسويق متاحة</p>
        @endif
    </div>

    <!-- الإحصائيات المالية -->
    <div class="section">
        <h2 class="section-title">الإحصائيات المالية</h2>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value success">{{ number_format($data['financial_stats']['total_income'], 2) }} ريال</div>
                <div class="stat-label">إجمالي الإيرادات</div>
            </div>
            <div class="stat-card">
                <div class="stat-value danger">{{ number_format($data['financial_stats']['total_expenses'], 2) }} ريال</div>
                <div class="stat-label">إجمالي المصروفات</div>
            </div>
            <div class="stat-card">
                <div class="stat-value {{ $data['financial_stats']['net_profit'] >= 0 ? 'success' : 'danger' }}">
                    {{ number_format($data['financial_stats']['net_profit'], 2) }} ريال
                </div>
                <div class="stat-label">صافي الربح</div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>تم إنشاء هذا التقرير تلقائياً من نظام Infinity Wear</p>
        <p>جميع الحقوق محفوظة © {{ date('Y') }}</p>
    </div>
</body>
</html>
