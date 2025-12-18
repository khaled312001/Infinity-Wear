@extends('layouts.dashboard')

@section('title', 'إدارة المستخدمين')
@section('page-title', 'إدارة المستخدمين')
@section('page-subtitle', 'إدارة جميع المستخدمين في النظام')

@section('page-actions')
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> إضافة مستخدم جديد
    </a>
    <a href="{{ route('admin.users.export', request()->query()) }}" class="btn btn-outline-success">
        <i class="fas fa-download"></i> تصدير
    </a>
@endsection

@section('content')
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $stats['total'] }}</h4>
                            <p class="mb-0">إجمالي المستخدمين</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-users fa-2x"></i>
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
                            <h4 class="mb-0">{{ $stats['active'] }}</h4>
                            <p class="mb-0">المستخدمين النشطين</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-user-check fa-2x"></i>
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
                            <h4 class="mb-0">{{ $stats['inactive'] }}</h4>
                            <p class="mb-0">المستخدمين غير النشطين</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-user-times fa-2x"></i>
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
                            <h4 class="mb-0">{{ $stats['by_type']['importer'] ?? 0 }}</h4>
                            <p class="mb-0">العملاء</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-truck fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.users.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="user_type" class="form-label">نوع المستخدم</label>
                        <select name="user_type" id="user_type" class="form-select">
                            <option value="">جميع الأنواع</option>
                            <option value="admin" {{ request('user_type') == 'admin' ? 'selected' : '' }}>مدير</option>
                            <option value="employee" {{ request('user_type') == 'employee' ? 'selected' : '' }}>موظف</option>
                            <option value="importer" {{ request('user_type') == 'importer' ? 'selected' : '' }}>عميل</option>
                            <option value="sales" {{ request('user_type') == 'sales' ? 'selected' : '' }}>مندوب مبيعات</option>
                            <option value="marketing" {{ request('user_type') == 'marketing' ? 'selected' : '' }}>موظف تسويق</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">الحالة</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">جميع الحالات</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>نشط</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="search" class="form-label">البحث</label>
                        <input type="text" name="search" id="search" class="form-control" 
                               placeholder="البحث بالاسم، البريد الإلكتروني، أو رقم الهاتف" 
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> بحث
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">قائمة المستخدمين</h5>
        </div>
        <div class="card-body p-0">
            @if($users->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0 table-sm" style="font-size: 0.8rem;">
                        <thead class="table-light">
                            <tr>
                                <th>المستخدم</th>
                                <th>النوع</th>
                                <th>البريد</th>
                                <th>الهاتف</th>
                                <th>المدينة</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($user->avatar)
                                                <img src="{{ asset('storage/' . $user->avatar) }}" 
                                                     alt="{{ $user->name }}" 
                                                     class="rounded-circle me-1" 
                                                     width="28" height="28">
                                            @else
                                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-1" 
                                                     style="width: 28px; height: 28px; font-size: 0.7rem;">
                                                    {{ substr($user->name, 0, 1) }}
                                                </div>
                                            @endif
                                            <span class="text-truncate" style="max-width: 100px;">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-sm bg-{{ $user->user_type == 'admin' ? 'danger' : ($user->user_type == 'importer' ? 'info' : 'secondary') }}">
                                            {{ $user->getUserTypeLabelAttribute() }}
                                        </span>
                                    </td>
                                    <td><small>{{ $user->email }}</small></td>
                                    <td><small>{{ $user->phone ?? '-' }}</small></td>
                                    <td><small>{{ $user->city ?? '-' }}</small></td>
                                    <td>
                                        @if($user->is_active)
                                            <span class="badge badge-sm bg-success">نشط</span>
                                        @else
                                            <span class="badge badge-sm bg-danger">غير نشط</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.users.show', $user) }}" 
                                               class="btn btn-outline-info btn-sm" 
                                               title="عرض">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.users.edit', $user) }}" 
                                               class="btn btn-outline-primary btn-sm" 
                                               title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" 
                                                  class="d-inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-{{ $user->is_active ? 'warning' : 'success' }}"
                                                        title="{{ $user->is_active ? 'إلغاء تفعيل' : 'تفعيل' }}"
                                                        onclick="return confirm('هل أنت متأكد من تغيير حالة المستخدم؟')">
                                                    <i class="fas fa-{{ $user->is_active ? 'ban' : 'check' }}"></i>
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف">
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
                <div class="card-footer">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                        <div class="text-muted small">
                            <i class="fas fa-info-circle me-1"></i>
                            عرض <strong>{{ $users->firstItem() ?? 0 }}</strong> إلى <strong>{{ $users->lastItem() ?? 0 }}</strong> 
                            من أصل <strong>{{ $users->total() }}</strong> مستخدم
                        </div>
                        <div class="pagination-wrapper">
                            {{ $users->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">لا توجد مستخدمين</h5>
                    <p class="text-muted">لم يتم العثور على مستخدمين مطابقين للبحث</p>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> إضافة مستخدم جديد
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* Statistics Cards */
    .row .card {
        transition: all 0.3s ease;
        border: none;
    }
    
    .row .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.15);
    }
    
    .row .card-body {
        padding: 1.25rem;
    }
    
    .row .card h4 {
        font-size: 2rem;
        font-weight: 700;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
    }
    
    .row .card p {
        font-size: 0.9rem;
        opacity: 0.95;
        font-weight: 500;
    }
    
    .row .card i {
        opacity: 0.8;
    }
    
    /* Table Styles */
    .table-sm td, .table-sm th {
        padding: 0.6rem 0.5rem;
        vertical-align: middle;
    }
    
    .table-sm thead th {
        background-color: #f8f9fa;
        color: #495057;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #dee2e6;
    }
    
    .table-hover tbody tr {
        transition: all 0.2s ease;
    }
    
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transform: scale(1.001);
    }
    
    .btn-group-sm .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        border-radius: 0.25rem;
        transition: all 0.2s ease;
    }
    
    .btn-group-sm .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.15);
    }
    
    .badge-sm {
        font-size: 0.7rem;
        padding: 0.35rem 0.65rem;
        font-weight: 500;
        border-radius: 0.25rem;
    }
    
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border-radius: 0.5rem;
    }
    
    /* Avatar Styles */
    .rounded-circle {
        border: 2px solid #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    /* Card Styles */
    .card {
        border-radius: 0.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        border: 1px solid #e3e6ea;
    }
    
    .card-header {
        background-color: #fff;
        border-bottom: 2px solid #e3e6ea;
        padding: 1rem 1.25rem;
    }
    
    .card-header h5 {
        color: #495057;
        font-weight: 600;
        font-size: 1.1rem;
    }
    
    /* Pagination Styles */
    .card-footer {
        background-color: #f8f9fa;
        border-top: 1px solid #dee2e6;
        padding: 1rem;
    }
    
    .pagination-wrapper {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .pagination-wrapper .pagination {
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.25rem;
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .pagination-wrapper .page-item {
        margin: 0;
    }
    
    .pagination-wrapper .page-link {
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        font-weight: 500;
        line-height: 1;
        border-radius: 0.375rem;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        color: #495057;
        background-color: #fff;
        border: 1px solid #dee2e6;
        transition: all 0.2s ease-in-out;
    }
    
    .pagination-wrapper .page-link:hover:not(.active) {
        color: #0d6efd;
        background-color: #e9ecef;
        border-color: #dee2e6;
        transform: translateY(-2px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .pagination-wrapper .page-item.active .page-link {
        z-index: 3;
        color: #fff;
        background-color: #0d6efd;
        border-color: #0d6efd;
        box-shadow: 0 2px 8px rgba(13, 110, 253, 0.3);
        font-weight: 600;
    }
    
    .pagination-wrapper .page-item.disabled .page-link {
        color: #adb5bd;
        pointer-events: none;
        background-color: #f8f9fa;
        border-color: #dee2e6;
        opacity: 0.6;
    }
    
    .pagination-wrapper svg {
        width: 14px;
        height: 14px;
        stroke-width: 2.5;
    }
    
    /* Showing Text Styles */
    .card-footer .text-muted {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .card-footer .text-muted strong {
        color: #495057;
    }
    
    .card-footer .text-muted i {
        color: #0d6efd;
    }
    
    /* Responsive Design */
    @media (max-width: 1400px) {
        .table {
            font-size: 0.75rem !important;
        }
    }
    
    @media (max-width: 768px) {
        .pagination-wrapper .page-link {
            padding: 0.4rem 0.6rem;
            font-size: 0.8rem;
            min-width: 36px;
            height: 36px;
        }
        
        .card-footer .text-muted {
            font-size: 0.75rem;
        }
        
        .table-sm td, .table-sm th {
            padding: 0.4rem 0.3rem;
            font-size: 0.75rem;
        }
        
        .btn-group-sm .btn {
            padding: 0.2rem 0.4rem;
            font-size: 0.7rem;
        }
        
        .row .card h4 {
            font-size: 1.5rem;
        }
        
        .row .card p {
            font-size: 0.8rem;
        }
    }
    
    @media (max-width: 576px) {
        .pagination-wrapper .page-link {
            min-width: 32px;
            height: 32px;
            padding: 0.3rem 0.5rem;
        }
        
        .card-footer > div {
            flex-direction: column;
            gap: 1rem;
        }
    }
</style>
@endpush

@section('scripts')
<script>
    // Auto-submit form on filter change
    document.getElementById('user_type').addEventListener('change', function() {
        this.form.submit();
    });
    
    document.getElementById('status').addEventListener('change', function() {
        this.form.submit();
    });
</script>
@endsection