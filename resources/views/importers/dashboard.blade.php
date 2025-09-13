@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">لوحة تحكم المستورد</h1>
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">معلومات المستورد</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>الاسم:</strong> {{ $importer->name }}</p>
                            <p><strong>البريد الإلكتروني:</strong> {{ $importer->email }}</p>
                            <p><strong>رقم الهاتف:</strong> {{ $importer->phone }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>نوع العمل:</strong> 
                                @if($importer->business_type == 'individual')
                                    فرد
                                @elseif($importer->business_type == 'company')
                                    شركة
                                @else
                                    آخر
                                @endif
                            </p>
                            @if($importer->business_type == 'company')
                                <p><strong>اسم الشركة:</strong> {{ $importer->company_name }}</p>
                                <p><strong>المنصب:</strong> {{ $importer->company_position }}</p>
                            @endif
                            <p><strong>العنوان:</strong> {{ $importer->address }}, {{ $importer->city }}, {{ $importer->country }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <h2 class="mb-3">الطلبات</h2>
            @if($orders->count() > 0)
                @foreach($orders as $order)
                    <div class="card shadow-sm mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">طلب #{{ $order->id }}</h5>
                            <span class="badge {{ $order->status == 'pending' ? 'bg-warning' : ($order->status == 'approved' ? 'bg-success' : 'bg-danger') }}">
                                @if($order->status == 'pending')
                                    قيد المراجعة
                                @elseif($order->status == 'approved')
                                    تمت الموافقة
                                @elseif($order->status == 'rejected')
                                    مرفوض
                                @else
                                    {{ $order->status }}
                                @endif
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>المتطلبات:</strong> {{ $order->requirements }}</p>
                                    <p><strong>الكمية:</strong> {{ $order->quantity }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>تفاصيل التصميم:</strong></p>
                                    @php
                                        $designDetails = json_decode($order->design_details, true);
                                    @endphp

                                    @if(isset($designDetails['option']))
                                        <div class="mb-2">
                                            <strong>نوع التصميم:</strong>
                                            @switch($designDetails['option'])
                                                @case('text')
                                                    وصف نصي
                                                    @break
                                                @case('upload')
                                                    تصميم مرفوع
                                                    @break
                                                @case('template')
                                                    تصميم جاهز
                                                    @break
                                                @case('ai')
                                                    تصميم بالذكاء الاصطناعي
                                                    @break
                                                @default
                                                    غير محدد
                                            @endswitch
                                        </div>

                                        @switch($designDetails['option'])
                                            @case('text')
                                                <div class="mb-2">
                                                    <strong>الوصف:</strong>
                                                    <p>{{ $designDetails['text'] ?? 'لا يوجد وصف' }}</p>
                                                </div>
                                                @break
                                            @case('upload')
                                                <div class="mb-2">
                                                    <strong>الملف:</strong>
                                                    @if(isset($designDetails['file_path']))
                                                        <p>
                                                            <a href="{{ asset('storage/' . $designDetails['file_path']) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-download"></i> عرض الملف
                                                            </a>
                                                        </p>
                                                    @else
                                                        <p>لا يوجد ملف</p>
                                                    @endif
                                                </div>
                                                @if(isset($designDetails['notes']))
                                                    <div class="mb-2">
                                                        <strong>ملاحظات:</strong>
                                                        <p>{{ $designDetails['notes'] }}</p>
                                                    </div>
                                                @endif
                                                @break
                                            @case('template')
                                                <div class="mb-2">
                                                    <strong>التصميم المختار:</strong>
                                                    <p>
                                                        @switch($designDetails['template'] ?? '')
                                                            @case('template1')
                                                                التصميم الكلاسيكي
                                                                @break
                                                            @case('template2')
                                                                التصميم مكةي
                                                                @break
                                                            @case('template3')
                                                                التصميم العصري
                                                                @break
                                                            @default
                                                                غير محدد
                                                        @endswitch
                                                    </p>
                                                </div>
                                                @if(isset($designDetails['notes']))
                                                    <div class="mb-2">
                                                        <strong>التعديلات المطلوبة:</strong>
                                                        <p>{{ $designDetails['notes'] }}</p>
                                                    </div>
                                                @endif
                                                @break
                                            @case('ai')
                                                <div class="mb-2">
                                                    <strong>وصف التصميم للذكاء الاصطناعي:</strong>
                                                    <p>{{ $designDetails['prompt'] ?? 'لا يوجد وصف' }}</p>
                                                </div>
                                                @if(isset($designDetails['style']))
                                                    <div class="mb-2">
                                                        <strong>نمط التصميم:</strong>
                                                        <p>
                                                            @switch($designDetails['style'])
                                                                @case('realistic')
                                                                    واقعي
                                                                    @break
                                                                @case('modern')
                                                                    عصري
                                                                    @break
                                                                @case('minimalist')
                                                                    بسيط
                                                                    @break
                                                                @case('sporty')
                                                                    رياضي
                                                                    @break
                                                                @case('elegant')
                                                                    أنيق
                                                                    @break
                                                                @default
                                                                    غير محدد
                                                            @endswitch
                                                        </p>
                                                    </div>
                                                @endif
                                                @break
                                        @endswitch
                                    @else
                                        <p>{{ is_array($designDetails) && isset($designDetails['details']) ? $designDetails['details'] : 'لا توجد تفاصيل' }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-muted">
                            <small>تاريخ الإنشاء: {{ $order->created_at->format('Y-m-d H:i') }}</small>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="alert alert-info">
                    لا توجد طلبات حتى الآن.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection