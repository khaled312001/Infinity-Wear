@extends('layouts.app')

@section('title', 'لوحة التحكم - Infinity Wear')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <span class="infinity-logo me-2"></span>
                        لوحة التحكم
                    </h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-tachometer-alt me-2"></i>
                        الرئيسية
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-tshirt me-2"></i>
                        المنتجات
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-tags me-2"></i>
                        الفئات
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-shopping-cart me-2"></i>
                        الطلبات
                    </a>
                    <a href="{{ route('admin.custom-designs.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-palette me-2"></i>
                        التصاميم المخصصة
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <i class="fas fa-users me-2"></i>
                        العملاء
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <i class="fas fa-chart-bar me-2"></i>
                        التقارير
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <i class="fas fa-cog me-2"></i>
                        الإعدادات
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="col-md-9 col-lg-10">
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="section-title">لوحة التحكم</h2>
                    <p class="text-muted">مرحبا بك في لوحة تحكم Infinity Wear</p>
                </div>
            </div>
            
            <!-- Statistics Cards -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0">150</h4>
                                    <p class="mb-0">إجمالي المنتجات</p>
                                </div>
                                <div class="infinity-logo" style="width: 50px; height: 50px;">
                                    <i class="fas fa-tshirt"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0">45</h4>
                                    <p class="mb-0">الطلبات الجديدة</p>
                                </div>
                                <div class="infinity-logo" style="width: 50px; height: 50px;">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0">25</h4>
                                    <p class="mb-0">التصاميم المخصصة</p>
                                </div>
                                <div class="infinity-logo" style="width: 50px; height: 50px;">
                                    <i class="fas fa-palette"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0">1,250</h4>
                                    <p class="mb-0">إجمالي العملاء</p>
                                </div>
                                <div class="infinity-logo" style="width: 50px; height: 50px;">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Orders -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">الطلبات الأخيرة</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>رقم الطلب</th>
                                            <th>العميل</th>
                                            <th>المبلغ</th>
                                            <th>الحالة</th>
                                            <th>التاريخ</th>
                                            <th>الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>#ORD-001</td>
                                            <td>أحمد محمد</td>
                                            <td>250 ريال</td>
                                            <td><span class="badge bg-warning">في الانتظار</span></td>
                                            <td>2025-09-05</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary">عرض</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>#ORD-002</td>
                                            <td>فاطمة علي</td>
                                            <td>180 ريال</td>
                                            <td><span class="badge bg-success">مكتمل</span></td>
                                            <td>2025-09-04</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary">عرض</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>#ORD-003</td>
                                            <td>محمد السعد</td>
                                            <td>320 ريال</td>
                                            <td><span class="badge bg-info">قيد المعالجة</span></td>
                                            <td>2025-09-03</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary">عرض</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
