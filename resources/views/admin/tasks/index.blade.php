@extends('layouts.dashboard')

@section('title', 'إدارة المهام')
@section('dashboard-title', 'إدارة المهام')
@section('page-title', 'قائمة المهام')
@section('page-subtitle', 'إدارة وتتبع جميع المهام في النظام')

{{-- Sidebar menu is now handled by the unified admin-sidebar partial --}}

@section('page-actions')
    <div class="d-flex gap-2">
        <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>
            مهمة جديدة
        </a>
        <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="fas fa-filter me-2"></i>
                تصفية
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#" onclick="filterTasks('all')">جميع المهام</a></li>
                <li><a class="dropdown-item" href="#" onclick="filterTasks('pending')">معلقة</a></li>
                <li><a class="dropdown-item" href="#" onclick="filterTasks('in_progress')">قيد التنفيذ</a></li>
                <li><a class="dropdown-item" href="#" onclick="filterTasks('completed')">مكتملة</a></li>
                <li><a class="dropdown-item" href="#" onclick="filterTasks('overdue')">متأخرة</a></li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- إحصائيات سريعة -->
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon primary me-3">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $stats['total'] }}</h3>
                        <p class="text-muted mb-0">إجمالي المهام</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon warning me-3">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $stats['pending'] }}</h3>
                        <p class="text-muted mb-0">مهام معلقة</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon info me-3">
                        <i class="fas fa-spinner"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $stats['in_progress'] }}</h3>
                        <p class="text-muted mb-0">قيد التنفيذ</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon success me-3">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $stats['completed'] }}</h3>
                        <p class="text-muted mb-0">مهام مكتملة</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- المهام المتأخرة -->
    @if($stats['overdue'] > 0)
        <div class="alert alert-warning" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                <div>
                    <h6 class="alert-heading mb-1">تنبيه: مهام متأخرة</h6>
                    <p class="mb-0">يوجد {{ $stats['overdue'] }} مهمة متأخرة تحتاج إلى متابعة فورية</p>
                </div>
            </div>
        </div>
    @endif

    <!-- جدول المهام -->
    <div class="dashboard-card">
        <div class="card-header bg-white border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2 text-primary"></i>
                    قائمة المهام
                </h5>
                <div class="d-flex gap-2">
                    <div class="input-group" style="width: 300px;">
                        <input type="text" class="form-control" placeholder="البحث في المهام..." id="searchInput">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>المهمة</th>
                            <th>المكلف</th>
                            <th>القسم</th>
                            <th>الأولوية</th>
                            <th>الحالة</th>
                            <th>تاريخ الاستحقاق</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $task)
                            <tr class="@if($task->due_date < now() && $task->status != 'completed') table-danger @endif">
                                <td>
                                    <div>
                                        <h6 class="mb-1">{{ $task->title }}</h6>
                                        <small class="text-muted">{{ Str::limit($task->description, 50) }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-2">
                                            <div class="avatar-initial bg-info rounded-circle">
                                                {{ substr($task->assignedAdmin->name ?? 'غير محدد', 0, 1) }}
                                            </div>
                                        </div>
                                        <span>{{ $task->assignedAdmin->name ?? 'غير محدد' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge 
                                        @switch($task->department)
                                            @case('admin') bg-primary @break
                                            @case('marketing') bg-warning @break
                                            @case('sales') bg-success @break
                                            @default bg-secondary
                                        @endswitch">
                                        @switch($task->department)
                                            @case('admin') الإدارة @break
                                            @case('marketing') التسويق @break
                                            @case('sales') المبيعات @break
                                            @default غير محدد
                                        @endswitch
                                    </span>
                                </td>
                                <td>
                                    <span class="badge 
                                        @switch($task->priority)
                                            @case('high') bg-danger @break
                                            @case('medium') bg-warning @break
                                            @case('low') bg-info @break
                                            @default bg-secondary
                                        @endswitch">
                                        @switch($task->priority)
                                            @case('high') عالية @break
                                            @case('medium') متوسطة @break
                                            @case('low') منخفضة @break
                                            @default غير محدد
                                        @endswitch
                                    </span>
                                </td>
                                <td>
                                    <span class="badge 
                                        @switch($task->status)
                                            @case('pending') bg-warning @break
                                            @case('in_progress') bg-info @break
                                            @case('completed') bg-success @break
                                            @case('cancelled') bg-danger @break
                                            @default bg-secondary
                                        @endswitch">
                                        @switch($task->status)
                                            @case('pending') معلقة @break
                                            @case('in_progress') قيد التنفيذ @break
                                            @case('completed') مكتملة @break
                                            @case('cancelled') ملغاة @break
                                            @default غير محدد
                                        @endswitch
                                    </span>
                                </td>
                                <td>
                                    <div>
                                        {{ $task->due_date->format('d/m/Y') }}
                                        <small class="d-block 
                                            @if($task->due_date < now() && $task->status != 'completed') text-danger
                                            @else text-muted
                                            @endif">
                                            {{ $task->due_date->diffForHumans() }}
                                        </small>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.tasks.show', $task->id) }}" 
                                           class="btn btn-sm btn-outline-info" 
                                           title="عرض التفاصيل">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.tasks.edit', $task->id) }}" 
                                           class="btn btn-sm btn-outline-warning" 
                                           title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger" 
                                                title="حذف"
                                                onclick="deleteTask({{ $task->id }}, '{{ $task->title }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-tasks fa-3x mb-3"></i>
                                        <h5>لا توجد مهام</h5>
                                        <p>لم يتم العثور على أي مهام في النظام</p>
                                        <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>
                                            إنشاء مهمة جديدة
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if($tasks->hasPages())
            <div class="card-footer bg-white border-top">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        عرض {{ $tasks->firstItem() }} إلى {{ $tasks->lastItem() }} من أصل {{ $tasks->total() }} مهمة
                    </div>
                    {{ $tasks->links() }}
                </div>
            </div>
        @endif
    </div>

    <!-- Modal لتأكيد الحذف -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">تأكيد الحذف</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>هل أنت متأكد من حذف المهمة <strong id="taskTitle"></strong>؟</p>
                    <p class="text-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        هذا الإجراء لا يمكن التراجع عنه!
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <form id="deleteForm" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i>
                            حذف
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .avatar-initial {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: white;
            font-size: 0.875rem;
        }
        
        .table th {
            font-weight: 600;
            color: #374151;
            border-bottom: 2px solid #e5e7eb;
        }
        
        .table td {
            vertical-align: middle;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .table tbody tr:hover {
            background-color: #f8fafc;
        }

        .table-danger {
            background-color: rgba(239, 68, 68, 0.1);
        }

        .table-danger:hover {
            background-color: rgba(239, 68, 68, 0.15) !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function deleteTask(taskId, taskTitle) {
            document.getElementById('taskTitle').textContent = taskTitle;
            document.getElementById('deleteForm').action = '/admin/tasks/' + taskId;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }

        function filterTasks(type) {
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                if (type === 'all') {
                    row.style.display = '';
                } else {
                    const statusBadge = row.querySelector('td:nth-child(5) .badge');
                    if (statusBadge) {
                        const status = statusBadge.textContent.trim();
                        let show = false;
                        
                        switch(type) {
                            case 'pending':
                                show = status === 'معلقة';
                                break;
                            case 'in_progress':
                                show = status === 'قيد التنفيذ';
                                break;
                            case 'completed':
                                show = status === 'مكتملة';
                                break;
                            case 'overdue':
                                show = row.classList.contains('table-danger');
                                break;
                        }
                        
                        row.style.display = show ? '' : 'none';
                    }
                }
            });
        }

        // البحث في الجدول
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('tbody tr');
            
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    </script>
@endpush