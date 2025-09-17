@extends('layouts.dashboard')

@section('title', 'إدارة خطط الشركة')
@section('dashboard-title', 'لوحة الإدارة')
@section('page-title', 'إدارة خطط الشركة')
@section('page-subtitle', 'عرض وإدارة جميع خطط الشركة الاستراتيجية')
@section('profile-route', '#')
@section('settings-route', '#')

@section('sidebar-menu')
    @include('partials.admin-sidebar')
@endsection

@section('page-actions')
    <a href="{{ route('admin.company-plans.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        إنشاء خطة جديدة
    </a>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- إحصائيات سريعة -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $stats['total'] }}</h4>
                            <p class="mb-0">إجمالي الخطط</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-chart-line fa-2x"></i>
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
                            <h4>{{ $stats['active'] }}</h4>
                            <p class="mb-0">خطط نشطة</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-play-circle fa-2x"></i>
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
                            <h4>{{ $stats['completed'] }}</h4>
                            <p class="mb-0">خطط مكتملة</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-secondary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $stats['draft'] }}</h4>
                            <p class="mb-0">مسودات</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-edit fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="card-header bg-white border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-chart-line me-2 text-primary"></i>
                    جميع خطط الشركة
                </h5>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" id="statusFilter">
                        <option value="">جميع الحالات</option>
                        <option value="draft">مسودة</option>
                        <option value="active">نشطة</option>
                        <option value="completed">مكتملة</option>
                        <option value="cancelled">ملغية</option>
                    </select>
                    <select class="form-select form-select-sm" id="typeFilter">
                        <option value="">جميع الأنواع</option>
                        <option value="quarterly">ربع سنوية</option>
                        <option value="semi_annual">نصف سنوية</option>
                        <option value="annual">سنوية</option>
                    </select>
                    <input type="text" class="form-control form-control-sm" placeholder="البحث في الخطط..." id="searchInput">
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($plans->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>عنوان الخطة</th>
                                <th>النوع</th>
                                <th>الحالة</th>
                                <th>التقدم</th>
                                <th>المدة</th>
                                <th>المسؤول</th>
                                <th>الميزانية</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($plans as $plan)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="fas fa-chart-line text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $plan->title }}</h6>
                                            <small class="text-muted">{{ Str::limit($plan->description, 50) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $plan->type_label }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $plan->status_color }}">{{ $plan->status_label }}</span>
                                    @if($plan->is_overdue)
                                        <span class="badge bg-danger ms-1">متأخرة</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar bg-{{ $plan->progress_percentage >= 100 ? 'success' : ($plan->progress_percentage >= 75 ? 'info' : ($plan->progress_percentage >= 50 ? 'warning' : 'danger')) }}" 
                                             role="progressbar" 
                                             style="width: {{ $plan->progress_percentage }}%">
                                            {{ $plan->progress_percentage }}%
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <small class="text-muted">من: {{ $plan->start_date->format('Y-m-d') }}</small><br>
                                        <small class="text-muted">إلى: {{ $plan->end_date->format('Y-m-d') }}</small>
                                        @if($plan->days_remaining > 0)
                                            <br><small class="text-info">{{ $plan->days_remaining }} يوم متبقي</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($plan->assignee)
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>
                                            <div>
                                                <small>{{ $plan->assignee->name }}</small>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">غير محدد</span>
                                    @endif
                                </td>
                                <td>
                                    @if($plan->budget)
                                        <div>
                                            <strong>{{ number_format($plan->budget, 2) }} ر.س</strong>
                                            @if($plan->actual_cost)
                                                <br><small class="text-muted">الفعلي: {{ number_format($plan->actual_cost, 2) }} ر.س</small>
                                                <br><small class="text-{{ $plan->cost_percentage > 100 ? 'danger' : 'success' }}">
                                                    ({{ $plan->cost_percentage }}%)
                                                </small>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-muted">غير محدد</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.company-plans.show', $plan) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.company-plans.edit', $plan) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-info dropdown-toggle" data-bs-toggle="dropdown">
                                                <i class="fas fa-cog"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <form action="{{ route('admin.company-plans.update-status', $plan) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="active">
                                                        <button type="submit" class="dropdown-item">تفعيل</button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form action="{{ route('admin.company-plans.update-status', $plan) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="completed">
                                                        <button type="submit" class="dropdown-item">إكمال</button>
                                                    </form>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('admin.company-plans.destroy', $plan) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('هل أنت متأكد من حذف هذه الخطة؟')">
                                                            حذف
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $plans->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-chart-line fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">لا توجد خطط حتى الآن</h4>
                    <p class="text-muted mb-4">ابدأ بإنشاء خطة استراتيجية جديدة للشركة</p>
                    <a href="{{ route('admin.company-plans.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>
                        إنشاء خطة جديدة
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // البحث في الخطط
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

    // فلترة حسب الحالة
    document.getElementById('statusFilter').addEventListener('change', function() {
        const status = this.value;
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            if (!status || row.querySelector('.badge').textContent.includes(status)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // فلترة حسب النوع
    document.getElementById('typeFilter').addEventListener('change', function() {
        const type = this.value;
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            if (!type || row.textContent.includes(type)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endpush