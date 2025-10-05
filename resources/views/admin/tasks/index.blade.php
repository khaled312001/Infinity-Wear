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
            <div class="stats-card h-100">
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
            <div class="stats-card h-100">
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
            <div class="stats-card h-100">
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
            <div class="stats-card h-100">
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
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2 text-primary"></i>
                    قائمة المهام
                </h5>
                <div class="d-flex gap-2 flex-wrap">
                    <div class="input-group" style="min-width: 250px;">
                        <input type="text" class="form-control" placeholder="البحث في المهام..." id="searchInput">
                        <button class="btn btn-outline-secondary" type="button" id="searchBtn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary" onclick="exportTasks()" title="تصدير">
                            <i class="fas fa-download"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="refreshTasks()" title="تحديث">
                            <i class="fas fa-sync-alt"></i>
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
                            <th width="30%">المهمة</th>
                            <th width="15%">المكلف</th>
                            <th width="10%">القسم</th>
                            <th width="10%">الأولوية</th>
                            <th width="10%">الحالة</th>
                            <th width="15%">تاريخ الاستحقاق</th>
                            <th width="10%">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $task)
                            <tr class="@if($task->due_date < now() && $task->status != 'completed') table-danger @endif">
                                <td>
                                    <div class="d-flex align-items-start">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-semibold">{{ $task->title }}</h6>
                                            <small class="text-muted d-block">{{ Str::limit($task->description, 60) }}</small>
                                            @if($task->labels && count($task->labels) > 0)
                                                <div class="mt-1">
                                                    @foreach(array_slice($task->labels, 0, 2) as $label)
                                                        <span class="badge bg-light text-dark me-1" style="font-size: 0.7rem;">{{ $label }}</span>
                                                    @endforeach
                                                    @if(count($task->labels) > 2)
                                                        <span class="badge bg-secondary" style="font-size: 0.7rem;">+{{ count($task->labels) - 2 }}</span>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-2">
                                            <div class="avatar-initial bg-info rounded-circle d-flex align-items-center justify-content-center">
                                                {{ substr($task->assignedAdmin->name ?? 'غير محدد', 0, 1) }}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="fw-medium">{{ $task->assignedAdmin->name ?? 'غير محدد' }}</div>
                                            @if($task->assignedAdmin)
                                                <small class="text-muted">{{ $task->assignedAdmin->email ?? '' }}</small>
                                            @endif
                                        </div>
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
                                    <div class="text-center">
                                        <div class="fw-medium">{{ $task->due_date->format('d/m/Y') }}</div>
                                        <small class="d-block 
                                            @if($task->due_date < now() && $task->status != 'completed') text-danger fw-bold
                                            @elseif($task->due_date->isToday()) text-warning fw-bold
                                            @elseif($task->due_date->isTomorrow()) text-info
                                            @else text-muted
                                            @endif">
                                            @if($task->due_date < now() && $task->status != 'completed')
                                                <i class="fas fa-exclamation-triangle me-1"></i>متأخرة
                                            @else
                                                {{ $task->due_date->diffForHumans() }}
                                            @endif
                                        </small>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.tasks.show', $task->id) }}" 
                                           class="btn btn-sm btn-outline-info" 
                                           title="عرض التفاصيل"
                                           data-bs-toggle="tooltip">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.tasks.edit', $task->id) }}" 
                                           class="btn btn-sm btn-outline-warning" 
                                           title="تعديل"
                                           data-bs-toggle="tooltip">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-success quick-status-btn" 
                                                title="تحديث الحالة"
                                                data-bs-toggle="tooltip"
                                                data-task-id="{{ $task->id }}"
                                                data-current-status="{{ $task->status }}">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger delete-task-btn" 
                                                title="حذف"
                                                data-bs-toggle="tooltip"
                                                data-task-id="{{ $task->id }}"
                                                data-task-title="{{ $task->title }}">
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

    <!-- Modal لتحديث الحالة السريع -->
    <div class="modal fade" id="statusModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">تحديث حالة المهمة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="statusForm">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="statusSelect" class="form-label">الحالة الجديدة</label>
                            <select class="form-select" id="statusSelect" name="status" required>
                                <option value="pending">معلقة</option>
                                <option value="in_progress">قيد التنفيذ</option>
                                <option value="completed">مكتملة</option>
                                <option value="cancelled">ملغاة</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="statusNote" class="form-label">ملاحظة (اختياري)</label>
                            <textarea class="form-control" id="statusNote" name="note" rows="3" placeholder="أضف ملاحظة حول التحديث..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="button" class="btn btn-primary" onclick="updateTaskStatus()">
                        <i class="fas fa-save me-2"></i>
                        تحديث
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .avatar-initial {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: white;
            font-size: 0.875rem;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }
        
        .table th {
            font-weight: 600;
            color: #374151;
            border-bottom: 2px solid #e5e7eb;
            background-color: #f8fafc;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        .table td {
            vertical-align: middle;
            border-bottom: 1px solid #f3f4f6;
            padding: 1rem 0.75rem;
        }
        
        .table tbody tr:hover {
            background-color: #f8fafc;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
        }

        .table-danger {
            background-color: rgba(239, 68, 68, 0.1);
            border-left: 4px solid #ef4444;
        }

        .table-danger:hover {
            background-color: rgba(239, 68, 68, 0.15) !important;
        }

        .stats-card {
            transition: all 0.3s ease;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 1.5rem;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        }

        .stats-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .stats-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .stats-icon.primary { background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white; }
        .stats-icon.warning { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; }
        .stats-icon.info { background: linear-gradient(135deg, #06b6d4, #0891b2); color: white; }
        .stats-icon.success { background: linear-gradient(135deg, #10b981, #059669); color: white; }

        .badge {
            font-size: 0.75rem;
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
        }

        .btn-group .btn {
            border-radius: 6px;
            margin: 0 2px;
        }

        .btn-group .btn:first-child {
            margin-left: 0;
        }

        .btn-group .btn:last-child {
            margin-right: 0;
        }

        .dashboard-card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-bottom: 1px solid #e5e7eb;
            padding: 1.5rem;
        }

        .input-group .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
        }

        .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .modal-header {
            border-bottom: 1px solid #e5e7eb;
            background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        }

        .form-select:focus, .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
        }

        @media (max-width: 768px) {
            .table-responsive {
                font-size: 0.875rem;
            }
            
            .btn-group .btn {
                padding: 0.375rem 0.5rem;
                font-size: 0.75rem;
            }
            
            .stats-card {
                padding: 1rem;
            }
            
            .stats-icon {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        let currentTaskId = null;

        // Initialize tooltips and event listeners
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Add event listeners for delete buttons
            document.querySelectorAll('.delete-task-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const taskId = this.getAttribute('data-task-id');
                    const taskTitle = this.getAttribute('data-task-title');
                    deleteTask(taskId, taskTitle);
                });
            });

            // Add event listeners for quick status update buttons
            document.querySelectorAll('.quick-status-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const taskId = this.getAttribute('data-task-id');
                    const currentStatus = this.getAttribute('data-current-status');
                    quickStatusUpdate(taskId, currentStatus);
                });
            });
        });

        function deleteTask(taskId, taskTitle) {
            document.getElementById('taskTitle').textContent = taskTitle;
            document.getElementById('deleteForm').action = '/admin/tasks/' + taskId;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }

        function quickStatusUpdate(taskId, currentStatus) {
            currentTaskId = taskId;
            document.getElementById('statusSelect').value = currentStatus;
            document.getElementById('statusNote').value = '';
            new bootstrap.Modal(document.getElementById('statusModal')).show();
        }

        function updateTaskStatus() {
            if (!currentTaskId) return;

            const status = document.getElementById('statusSelect').value;
            const note = document.getElementById('statusNote').value;

            fetch(`/admin/tasks/${currentTaskId}/status`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    status: status,
                    note: note
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('تم تحديث حالة المهمة بنجاح', 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showNotification('حدث خطأ في تحديث الحالة', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('حدث خطأ في الاتصال', 'error');
            });

            bootstrap.Modal.getInstance(document.getElementById('statusModal')).hide();
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

        function exportTasks() {
            showNotification('جاري تصدير المهام...', 'info');
            // Implement export functionality here
        }

        function refreshTasks() {
            showNotification('جاري تحديث البيانات...', 'info');
            setTimeout(() => {
                location.reload();
            }, 1000);
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

        // Search button functionality
        document.getElementById('searchBtn').addEventListener('click', function() {
            const searchInput = document.getElementById('searchInput');
            searchInput.focus();
        });

        // Enter key search
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                this.blur();
            }
        });

        // Show notification function
        function showNotification(message, type = 'info') {
            const alertClass = {
                'success': 'alert-success',
                'error': 'alert-danger',
                'warning': 'alert-warning',
                'info': 'alert-info'
            }[type] || 'alert-info';

            const icon = {
                'success': 'fas fa-check-circle',
                'error': 'fas fa-exclamation-circle',
                'warning': 'fas fa-exclamation-triangle',
                'info': 'fas fa-info-circle'
            }[type] || 'fas fa-info-circle';

            const alert = document.createElement('div');
            alert.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
            alert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            alert.innerHTML = `
                <i class="${icon} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            document.body.appendChild(alert);

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.remove();
                }
            }, 5000);
        }

        // Auto-refresh stats every 30 seconds
        setInterval(function() {
            // You can implement auto-refresh of stats here if needed
        }, 30000);
    </script>
@endpush