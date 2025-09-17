@extends('layouts.dashboard')

@section('title', 'قاعدة بيانات العملاء')
@section('dashboard-title', 'لوحة الإدارة')
@section('page-title', 'قاعدة بيانات العملاء')
@section('page-subtitle', 'إدارة ملاحظات فريق التسويق والمبيعات على العملاء')
@section('profile-route', '#')
@section('settings-route', '#')

@section('sidebar-menu')
    @include('partials.admin-sidebar')
@endsection

@section('page-actions')
    <a href="{{ route('admin.customer-notes.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        إضافة ملاحظة جديدة
    </a>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- الإحصائيات السريعة -->
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon primary me-3">
                        <i class="fas fa-sticky-note"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $stats['total_notes'] }}</h3>
                        <p class="text-muted mb-0">إجمالي الملاحظات</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon info me-3">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $stats['marketing_notes'] }}</h3>
                        <p class="text-muted mb-0">ملاحظات التسويق</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon success me-3">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $stats['sales_notes'] }}</h3>
                        <p class="text-muted mb-0">ملاحظات المبيعات</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon danger me-3">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $stats['high_priority'] }}</h3>
                        <p class="text-muted mb-0">أولوية عالية</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- الفلاتر والبحث -->
    <div class="dashboard-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.customer-notes.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">نوع الملاحظة</label>
                    <select name="note_type" class="form-select">
                        <option value="">جميع الأنواع</option>
                        <option value="marketing" {{ request('note_type') == 'marketing' ? 'selected' : '' }}>تسويق</option>
                        <option value="sales" {{ request('note_type') == 'sales' ? 'selected' : '' }}>مبيعات</option>
                        <option value="general" {{ request('note_type') == 'general' ? 'selected' : '' }}>عام</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">العميل</label>
                    <select name="customer_id" class="form-select">
                        <option value="">جميع العملاء</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }} ({{ $customer->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">الأولوية</label>
                    <select name="priority" class="form-select">
                        <option value="">جميع الأولويات</option>
                        <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>منخفضة</option>
                        <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>متوسطة</option>
                        <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>عالية</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">البحث</label>
                    <input type="text" name="search" class="form-control" placeholder="البحث في العنوان أو المحتوى..." value="{{ request('search') }}">
                </div>

                <div class="col-md-1">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- قائمة الملاحظات -->
    <div class="dashboard-card">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0">
                <i class="fas fa-sticky-note me-2 text-primary"></i>
                ملاحظات العملاء
            </h5>
        </div>
        <div class="card-body">
            @if($notes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>العميل</th>
                                <th>العنوان</th>
                                <th>النوع</th>
                                <th>الأولوية</th>
                                <th>أضيف بواسطة</th>
                                <th>تاريخ الإضافة</th>
                                <th>متابعة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($notes as $note)
                            <tr>
                                <td>{{ $note->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="fas fa-user text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $note->customer->name }}</h6>
                                            <small class="text-muted">{{ $note->customer->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-truncate" style="max-width: 200px;" title="{{ $note->title }}">
                                        {{ $note->title }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $note->note_type_color }}">
                                        {{ $note->note_type_label }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $note->priority_color }}">
                                        {{ $note->priority_label }}
                                    </span>
                                </td>
                                <td>{{ $note->addedBy->name }}</td>
                                <td>{{ $note->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    @if($note->follow_up_date)
                                        <small class="text-muted">
                                            {{ $note->follow_up_date->format('Y-m-d') }}
                                        </small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.customer-notes.show', $note) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.customer-notes.edit', $note) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.customer-notes.archive', $note) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-warning" onclick="return confirm('هل أنت متأكد من أرشفة هذه الملاحظة؟')">
                                                <i class="fas fa-archive"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.customer-notes.destroy', $note) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('هل أنت متأكد من حذف هذه الملاحظة؟')">
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
                    {{ $notes->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-sticky-note fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">لا توجد ملاحظات حتى الآن</h4>
                    <p class="text-muted mb-4">ابدأ بإضافة ملاحظة جديدة للعملاء</p>
                    <a href="{{ route('admin.customer-notes.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>
                        إضافة ملاحظة جديدة
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // البحث السريع
    document.querySelector('input[name="search"]').addEventListener('input', function() {
        if (this.value.length > 2) {
            // يمكن إضافة AJAX search هنا
        }
    });
</script>
@endpush