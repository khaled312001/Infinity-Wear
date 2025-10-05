@extends('layouts.sales-dashboard')

@section('title', 'تفاصيل المستورد - فريق المبيعات')
@section('dashboard-title', 'تفاصيل المستورد')
@section('page-title', 'تفاصيل المستورد')
@section('page-subtitle', 'عرض تفاصيل المستورد')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-industry me-2"></i>
                    تفاصيل المستورد
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>معلومات الشركة</h6>
                        <ul class="list-unstyled">
                            <li><strong>اسم الشركة:</strong> {{ $importer->company_name ?? 'غير محدد' }}</li>
                            <li><strong>جهة الاتصال:</strong> {{ $importer->contact_name ?? 'غير محدد' }}</li>
                            <li><strong>الهاتف:</strong> {{ $importer->phone ?? 'غير محدد' }}</li>
                            <li><strong>البريد الإلكتروني:</strong> {{ $importer->email ?? 'غير محدد' }}</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>معلومات إضافية</h6>
                        <ul class="list-unstyled">
                            <li><strong>الحالة:</strong> 
                                @switch($importer->status)
                                    @case('new')
                                        <span class="badge bg-primary">جديد</span>
                                        @break
                                    @case('contacted')
                                        <span class="badge bg-info">تم التواصل</span>
                                        @break
                                    @case('qualified')
                                        <span class="badge bg-success">مؤهل</span>
                                        @break
                                    @case('unqualified')
                                        <span class="badge bg-danger">غير مؤهل</span>
                                        @break
                                @endswitch
                            </li>
                            <li><strong>تاريخ التسجيل:</strong> {{ $importer->created_at->format('Y-m-d H:i') }}</li>
                            <li><strong>آخر تحديث:</strong> {{ $importer->updated_at->format('Y-m-d H:i') }}</li>
                        </ul>
                    </div>
                </div>
                
                @if($importer->notes)
                    <div class="mt-3">
                        <h6>ملاحظات</h6>
                        <div class="alert alert-info">
                            {{ $importer->notes }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-cogs me-2"></i>
                    إدارة المستورد
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('sales.importers.update-status', $importer) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="status" class="form-label">تغيير الحالة</label>
                        <select name="status" id="status" class="form-select">
                            <option value="new" {{ $importer->status === 'new' ? 'selected' : '' }}>جديد</option>
                            <option value="contacted" {{ $importer->status === 'contacted' ? 'selected' : '' }}>تم التواصل</option>
                            <option value="qualified" {{ $importer->status === 'qualified' ? 'selected' : '' }}>مؤهل</option>
                            <option value="unqualified" {{ $importer->status === 'unqualified' ? 'selected' : '' }}>غير مؤهل</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">ملاحظات</label>
                        <textarea name="notes" id="notes" class="form-control" rows="3">{{ $importer->notes }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save me-2"></i>
                        حفظ التغييرات
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
