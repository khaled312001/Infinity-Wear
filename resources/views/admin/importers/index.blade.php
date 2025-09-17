@extends('layouts.dashboard')

@section('title', 'إدارة المستوردين')
@section('dashboard-title', 'لوحة الإدارة')
@section('page-title', 'إدارة المستوردين')
@section('page-subtitle', 'عرض وإدارة جميع المستوردين في النظام')
@section('profile-route', '#')
@section('settings-route', '#')

@section('sidebar-menu')
    @include('partials.admin-sidebar')
@endsection

@section('page-actions')
    <a href="{{ route('admin.importers.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        إضافة مستورد جديد
    </a>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="dashboard-card">
        <div class="card-header bg-white border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-users me-2 text-primary"></i>
                    جميع المستوردين
                </h5>
                <div class="d-flex gap-2">
                    <input type="text" class="form-control form-control-sm" placeholder="البحث في المستوردين..." id="searchInput">
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($importers->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>البريد الإلكتروني</th>
                                <th>الهاتف</th>
                                <th>نوع النشاط</th>
                                <th>الحالة</th>
                                <th>تاريخ التسجيل</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($importers as $importer)
                            <tr>
                                <td>{{ $importer->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="fas fa-user text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $importer->name }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $importer->email }}</td>
                                <td>{{ $importer->phone ?? 'غير محدد' }}</td>
                                <td>{{ $importer->business_type_label ?? 'غير محدد' }}</td>
                                <td>
                                    @if($importer->status == 'new')
                                        <span class="badge bg-primary">جديد</span>
                                    @elseif($importer->status == 'contacted')
                                        <span class="badge bg-info">تم التواصل</span>
                                    @elseif($importer->status == 'qualified')
                                        <span class="badge bg-warning">مؤهل</span>
                                    @elseif($importer->status == 'proposal')
                                        <span class="badge bg-secondary">تم تقديم عرض</span>
                                    @elseif($importer->status == 'negotiation')
                                        <span class="badge bg-warning">قيد التفاوض</span>
                                    @elseif($importer->status == 'closed_won')
                                        <span class="badge bg-success">تم إغلاق الصفقة بنجاح</span>
                                    @elseif($importer->status == 'closed_lost')
                                        <span class="badge bg-danger">تم إغلاق الصفقة بدون نجاح</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $importer->status }}</span>
                                    @endif
                                </td>
                                <td>{{ $importer->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.importers.show', $importer->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.importers.edit', $importer->id) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.importers.destroy', $importer->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('هل أنت متأكد من حذف هذا المستورد؟')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $importers->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">لا يوجد مستوردين حتى الآن</h4>
                    <p class="text-muted mb-4">ابدأ بإضافة مستورد جديد للنظام</p>
                    <a href="{{ route('admin.importers.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>
                        إضافة مستورد جديد
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // البحث في المستوردين
    document.getElementById('searchInput').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endpush