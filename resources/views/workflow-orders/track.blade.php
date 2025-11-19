<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تتبع الطلب - Infinity Wear</title>
    
    <!-- Bootstrap RTL -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Cairo', sans-serif;
        }
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 0;
        }
        .track-container {
            max-width: 900px;
            margin: 0 auto;
        }
        .track-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
        }
        .stage-item {
            position: relative;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 12px;
            background: #f8f9fa;
            transition: all 0.3s ease;
        }
        .stage-item.completed {
            background: #d4edda;
            border-right: 4px solid #28a745;
        }
        .stage-item.in_progress {
            background: #fff3cd;
            border-right: 4px solid #ffc107;
        }
        .stage-item.pending {
            background: #e9ecef;
            border-right: 4px solid #6c757d;
        }
        .stage-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            margin-left: 20px;
        }
        .stage-icon.completed {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        }
        .stage-icon.in_progress {
            background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
        }
        .stage-icon.pending {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="track-container">
            <div class="track-card">
                <div class="text-center mb-4">
                    <h1 class="mb-3">
                        <i class="fas fa-search text-primary me-2"></i>
                        تتبع الطلب
                    </h1>
                    <form method="GET" action="{{ route('order.track') }}" class="d-flex gap-2">
                        <input type="text" name="order_number" class="form-control form-control-lg" placeholder="أدخل رقم الطلب" value="{{ request('order_number') }}" required>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-search me-2"></i>بحث
                        </button>
                    </form>
                </div>

                @if(isset($order))
                    <div class="alert alert-info">
                        <h5 class="mb-2">
                            <i class="fas fa-shopping-bag me-2"></i>
                            طلب رقم: <strong>{{ $order->order_number }}</strong>
                        </h5>
                        <p class="mb-0">
                            <strong>العميل:</strong> {{ $order->customer_name }} | 
                            <strong>الحالة:</strong> <span class="badge bg-primary">{{ $order->overall_status_label }}</span>
                        </p>
                    </div>

                    @php
                        $stages = [
                            'marketing' => ['name' => 'التسويق', 'icon' => 'fas fa-bullhorn', 'status' => $order->marketing_status],
                            'sales' => ['name' => 'المبيعات', 'icon' => 'fas fa-handshake', 'status' => $order->sales_status],
                            'design' => ['name' => 'التصميم', 'icon' => 'fas fa-palette', 'status' => $order->design_status],
                            'first_sample' => ['name' => 'العينة الأولى', 'icon' => 'fas fa-clipboard-check', 'status' => $order->first_sample_status],
                            'work_approval' => ['name' => 'اعتماد الشغل', 'icon' => 'fas fa-check-circle', 'status' => $order->work_approval_status],
                            'manufacturing' => ['name' => 'التصنيع', 'icon' => 'fas fa-industry', 'status' => $order->manufacturing_status],
                            'shipping' => ['name' => 'الشحن', 'icon' => 'fas fa-truck', 'status' => $order->shipping_status],
                            'receipt_delivery' => ['name' => 'استلام وتسليم', 'icon' => 'fas fa-box-open', 'status' => $order->receipt_delivery_status],
                            'collection' => ['name' => 'التحصيل', 'icon' => 'fas fa-money-bill-wave', 'status' => $order->collection_status],
                            'after_sales' => ['name' => 'خدمة ما بعد البيع', 'icon' => 'fas fa-headset', 'status' => $order->after_sales_status],
                        ];
                    @endphp

                    @foreach($stages as $stageKey => $stageInfo)
                        @php
                            $status = $stageInfo['status'];
                            $statusClass = 'pending';
                            $statusLabel = 'في الانتظار';
                            
                            if ($status == 'completed' || $status == 'approved') {
                                $statusClass = 'completed';
                                $statusLabel = 'مكتمل';
                            } elseif ($status == 'in_progress') {
                                $statusClass = 'in_progress';
                                $statusLabel = 'قيد التنفيذ';
                            } elseif ($status == 'rejected') {
                                $statusClass = 'rejected';
                                $statusLabel = 'مرفوض';
                            }
                        @endphp
                        <div class="stage-item {{ $statusClass }}">
                            <div class="d-flex align-items-center">
                                <div class="stage-icon {{ $statusClass }}">
                                    <i class="{{ $stageInfo['icon'] }}"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-1">{{ $stageInfo['name'] }}</h5>
                                    <p class="mb-0 text-muted">
                                        <span class="badge bg-{{ $statusClass == 'completed' ? 'success' : ($statusClass == 'in_progress' ? 'warning' : 'secondary') }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if($order->tracking_number)
                        <div class="alert alert-success mt-4">
                            <h6><i class="fas fa-truck me-2"></i>رقم التتبع</h6>
                            <code class="fs-5">{{ $order->tracking_number }}</code>
                        </div>
                    @endif
                @elseif(request('order_number'))
                    <div class="alert alert-warning text-center">
                        <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
                        <h5>لم يتم العثور على الطلب</h5>
                        <p>يرجى التحقق من رقم الطلب والمحاولة مرة أخرى</p>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">أدخل رقم الطلب للبحث</h5>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

