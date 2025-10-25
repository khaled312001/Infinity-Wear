@extends('layouts.dashboard')

@section('page-title', 'الدعم الفني')
@section('page-subtitle', 'صفحة الدعم الفني للمشرف')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-life-ring me-2"></i>
                    نظام الدعم الفني
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- إحصائيات سريعة -->
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 class="mb-0">{{ \App\Models\Contact::count() }}</h4>
                                        <p class="mb-0">إجمالي التذاكر</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-ticket-alt fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 class="mb-0">{{ \App\Models\Contact::whereIn('status', ['new'])->count() }}</h4>
                                        <p class="mb-0">تذاكر جديدة</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-exclamation-circle fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 class="mb-0">{{ \App\Models\Contact::whereIn('status', ['read', 'replied'])->count() }}</h4>
                                        <p class="mb-0">قيد المراجعة</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-clock fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 class="mb-0">{{ \App\Models\Contact::where('status', 'closed')->count() }}</h4>
                                        <p class="mb-0">تم الحل</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-check-circle fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- روابط سريعة -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="mb-3">روابط سريعة</h6>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('admin.contacts') }}" class="btn btn-outline-primary">
                                <i class="fas fa-envelope me-1"></i>
                                إدارة رسائل التواصل
                            </a>
                            <a href="{{ route('admin.whatsapp.index') }}" class="btn btn-outline-success">
                                <i class="fas fa-comments me-1"></i>
                                رسائل الواتساب
                            </a>
                            <a href="{{ route('admin.importers.index') }}" class="btn btn-outline-info">
                                <i class="fas fa-users me-1"></i>
                                إدارة المستوردين
                            </a>
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-warning">
                                <i class="fas fa-shopping-cart me-1"></i>
                                إدارة الطلبات
                            </a>
                        </div>
                    </div>
                </div>

                <!-- معلومات النظام -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0">
                                    <i class="fas fa-info-circle me-2"></i>
                                    معلومات النظام
                                </h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2">
                                        <strong>إصدار Laravel:</strong> {{ app()->version() }}
                                    </li>
                                    <li class="mb-2">
                                        <strong>إصدار PHP:</strong> {{ PHP_VERSION }}
                                    </li>
                                    <li class="mb-2">
                                        <strong>البيئة:</strong> {{ app()->environment() }}
                                    </li>
                                    <li class="mb-2">
                                        <strong>الوقت الحالي:</strong> {{ now()->format('Y-m-d H:i:s') }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0">
                                    <i class="fas fa-tools me-2"></i>
                                    أدوات النظام
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('admin.settings') }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-cog me-1"></i>
                                        إعدادات النظام
                                    </a>
                                    <a href="{{ route('admin.reports') }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        التقارير
                                    </a>
                                    <a href="{{ route('admin.notifications') }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-bell me-1"></i>
                                        الإشعارات
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


