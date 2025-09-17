@extends('layouts.dashboard')

@section('title', 'عرض بيانات المستورد')
@section('dashboard-title', 'لوحة الإدارة')
@section('page-title', 'عرض بيانات المستورد')
@section('page-subtitle', 'عرض بيانات المستورد: ' . $importer->name)

@section('sidebar-menu')
    @include('partials.admin-sidebar')
@endsection

@section('content')
    <div class="dashboard-card">
        <div class="card-header bg-white border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-user me-2 text-primary"></i>
                    بيانات المستورد
                </h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.importers.edit', $importer->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit me-1"></i>
                        تعديل
                    </a>
                    <a href="{{ route('admin.importers.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-right me-1"></i>
                        العودة
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">الاسم:</label>
                                <p class="form-control-plaintext">{{ $importer->name }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">البريد الإلكتروني:</label>
                                <p class="form-control-plaintext">{{ $importer->email }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">الهاتف:</label>
                                <p class="form-control-plaintext">{{ $importer->phone ?? 'غير محدد' }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">اسم الشركة:</label>
                                <p class="form-control-plaintext">{{ $importer->company_name ?? 'غير محدد' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">نوع النشاط:</label>
                                <p class="form-control-plaintext">{{ $importer->business_type_label }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">الحالة:</label>
                                <p class="form-control-plaintext">
                                    <span class="badge bg-info">{{ $importer->status_label }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">المدينة:</label>
                                <p class="form-control-plaintext">{{ $importer->city ?? 'غير محدد' }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">البلد:</label>
                                <p class="form-control-plaintext">{{ $importer->country ?? 'غير محدد' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    @if($importer->address)
                    <div class="mb-3">
                        <label class="form-label fw-bold">العنوان:</label>
                        <p class="form-control-plaintext">{{ $importer->address }}</p>
                    </div>
                    @endif
                    
                    @if($importer->notes)
                    <div class="mb-3">
                        <label class="form-label fw-bold">ملاحظات:</label>
                        <p class="form-control-plaintext">{{ $importer->notes }}</p>
                    </div>
                    @endif
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">تاريخ التسجيل:</label>
                                <p class="form-control-plaintext">{{ $importer->created_at->format('Y-m-d H:i') }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">آخر تحديث:</label>
                                <p class="form-control-plaintext">{{ $importer->updated_at->format('Y-m-d H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-user-circle fa-5x text-primary"></i>
                            </div>
                            <h5>{{ $importer->name }}</h5>
                            <p class="text-muted">{{ $importer->business_type_label }}</p>
                            <span class="badge bg-info">{{ $importer->status_label }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            @if($orders->count() > 0)
            <div class="mt-4">
                <h6 class="mb-3">طلبات المستورد</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>رقم الطلب</th>
                                <th>المنتج</th>
                                <th>الكمية</th>
                                <th>الحالة</th>
                                <th>تاريخ الطلب</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->product_name ?? 'غير محدد' }}</td>
                                <td>{{ $order->quantity ?? 'غير محدد' }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ $order->status ?? 'غير محدد' }}</span>
                                </td>
                                <td>{{ $order->created_at->format('Y-m-d') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
