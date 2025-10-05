@extends('layouts.sales-dashboard')

@section('title', 'المستوردين - فريق المبيعات')
@section('dashboard-title', 'المستوردين')
@section('page-title', 'قائمة المستوردين')
@section('page-subtitle', 'إدارة وتتبع المستوردين')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-industry me-2"></i>
            قائمة المستوردين
        </h5>
    </div>
    <div class="card-body">
        @if($importers->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>اسم الشركة</th>
                            <th>جهة الاتصال</th>
                            <th>الهاتف</th>
                            <th>البريد الإلكتروني</th>
                            <th>الحالة</th>
                            <th>تاريخ التسجيل</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($importers as $importer)
                            <tr>
                                <td>{{ $importer->company_name ?? 'غير محدد' }}</td>
                                <td>{{ $importer->contact_name ?? 'غير محدد' }}</td>
                                <td>{{ $importer->phone ?? 'غير محدد' }}</td>
                                <td>{{ $importer->email ?? 'غير محدد' }}</td>
                                <td>
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
                                        @default
                                            <span class="badge bg-secondary">{{ $importer->status }}</span>
                                    @endswitch
                                </td>
                                <td>{{ $importer->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <a href="{{ route('sales.importers.show', $importer) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $importers->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-industry fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">لا يوجد مستوردين حالياً</h5>
            </div>
        @endif
    </div>
</div>
@endsection