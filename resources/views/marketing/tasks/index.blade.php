@extends('layouts.dashboard')

@section('title', 'إدارة المهام - التسويق')
@section('dashboard-title', 'إدارة المهام')
@section('page-title', 'لوحة المهام')
@section('page-subtitle', 'نظام إدارة المهام لفريق التسويق')

@section('page-actions')
    <div class="d-flex gap-2">
        <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="fas fa-filter me-2"></i>
                تصفية
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#" onclick="filterTasks('all')">جميع المهام</a></li>
                <li><a class="dropdown-item" href="#" onclick="filterTasks('my')">مهامي</a></li>
                <li><a class="dropdown-item" href="#" onclick="filterTasks('urgent')">عاجلة</a></li>
                <li><a class="dropdown-item" href="#" onclick="filterTasks('overdue')">متأخرة</a></li>
            </ul>
        </div>
        <div class="alert alert-info mb-0 d-flex align-items-center">
            <i class="fas fa-info-circle me-2"></i>
            <small>يمكنك فقط نقل المهام وإضافة تعليقات</small>
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
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="stats-card h-100">
                <div class="d-flex align-items-center">
                    <div class="stats-icon primary me-3">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $stats['total_tasks'] }}</h3>
                        <p class="text-muted mb-0">إجمالي المهام</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="stats-card h-100">
                <div class="d-flex align-items-center">
                    <div class="stats-icon success me-3">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $stats['completed_tasks'] }}</h3>
                        <p class="text-muted mb-0">مكتملة</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="stats-card h-100">
                <div class="d-flex align-items-center">
                    <div class="stats-icon warning me-3">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $stats['in_progress_tasks'] }}</h3>
                        <p class="text-muted mb-0">قيد التنفيذ</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="stats-card h-100">
                <div class="d-flex align-items-center">
                    <div class="stats-icon info me-3">
                        <i class="fas fa-pause-circle"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $stats['pending_tasks'] }}</h3>
                        <p class="text-muted mb-0">معلقة</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="stats-card h-100">
                <div class="d-flex align-items-center">
                    <div class="stats-icon danger me-3">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $stats['overdue_tasks'] }}</h3>
                        <p class="text-muted mb-0">متأخرة</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="stats-card h-100">
                <div class="d-flex align-items-center">
                    <div class="stats-icon danger me-3">
                        <i class="fas fa-fire"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $stats['urgent_tasks'] }}</h3>
                        <p class="text-muted mb-0">عاجلة</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- لوحات المهام -->
    <div class="task-boards-container">
        @foreach($boards as $board)
            <div class="task-board" data-board-id="{{ $board->id }}">
                <div class="board-header">
                    <div class="board-title">
                        <i class="{{ $board->board_icon }}" style="color: {{ $board->board_color ?? '#6c757d' }}"></i>
                        <h4>{{ $board->name }}</h4>
                        <span class="badge bg-secondary">{{ $board->board_type_label }}</span>
                    </div>
                </div>

                <div class="board-content">
                    <div class="columns-container" id="board-{{ $board->id }}-columns">
                        @foreach($board->columns as $column)
                            <div class="task-column" data-column-id="{{ $column->id }}" data-board-id="{{ $board->id }}">
                                <div class="column-header">
                                    <div class="column-title">
                                        <i class="{{ $column->column_icon }}" style="color: {{ $column->column_color ?? '#6c757d' }}"></i>
                                        <span>{{ $column->name }}</span>
                                        <span class="task-count">{{ $column->active_tasks_count }}</span>
                                    </div>
                                    <div class="column-actions">
                                        <span class="badge bg-light text-dark">فريق التسويق</span>
                                    </div>
                                </div>

                                <div class="column-content" id="column-{{ $column->id }}-tasks">
                                    @foreach($column->tasks as $task)
                                        <div class="task-card" data-task-id="{{ $task->id }}" draggable="true">
                                            <div class="task-header">
                                                <div class="task-priority priority-{{ $task->priority }}"></div>
                                                @if($task->is_urgent)
                                                    <i class="fas fa-fire text-danger"></i>
                                                @endif
                                                @if($task->is_overdue)
                                                    <i class="fas fa-exclamation-triangle text-warning"></i>
                                                @endif
                                            </div>
                                            
                                            <div class="task-title">{{ $task->title }}</div>
                                            
                                            @if($task->description)
                                                <div class="task-description">{{ Str::limit($task->description, 100) }}</div>
                                            @endif

                                            @if($task->labels && count($task->labels) > 0)
                                                <div class="task-labels">
                                                    @foreach($task->labels as $label)
                                                        <span class="label" style="background-color: {{ $label['color'] ?? '#6c757d' }}">
                                                            {{ $label['name'] }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif

                                            @if($task->checklist && count($task->checklist) > 0)
                                                <div class="task-progress">
                                                    <div class="progress">
                                                        <div class="progress-bar" style="width: {{ $task->progress_percentage ?? 0 }}%"></div>
                                                    </div>
                                                    <small class="text-muted">{{ $task->progress_percentage }}%</small>
                                                </div>
                                            @endif

                                            <div class="task-footer">
                                                @if($task->assignedUser)
                                                    <div class="assigned-user">
                                                        <i class="fas fa-user"></i>
                                                        {{ $task->assignedUser->name }}
                                                    </div>
                                                @endif
                                                
                                                @if($task->due_date)
                                                    <div class="due-date @if($task->is_overdue) overdue @elseif($task->is_due_soon) due-soon @endif">
                                                        <i class="fas fa-calendar"></i>
                                                        {{ $task->due_date->format('Y-m-d') }}
                                                    </div>
                                                @endif

                                                <div class="task-actions">
                                                    <button class="btn btn-sm btn-outline-primary" data-task-id="{{ $task->id }}" onclick="viewTask(this.dataset.taskId)" title="عرض التفاصيل">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-info" data-task-id="{{ $task->id }}" onclick="addComment(this.dataset.taskId)" title="إضافة تعليق">
                                                        <i class="fas fa-comment"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal إضافة تعليق -->
    <div class="modal fade" id="addCommentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">إضافة تعليق</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="addCommentForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="commentText" class="form-label">التعليق</label>
                            <textarea class="form-control" id="commentText" name="comment" rows="4" placeholder="اكتب تعليقك هنا..." required></textarea>
                            <div class="form-text">سيظهر هذا التعليق للأدمن</div>
                        </div>
                        <input type="hidden" id="commentTaskId" name="task_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">إضافة التعليق</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/task-management.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/task-management.js') }}"></script>
<script>
    // تهيئة النظام
    document.addEventListener('DOMContentLoaded', function() {
        initializeTaskManagement();
    });

    // وظيفة إضافة تعليق
    function addComment(taskId) {
        document.getElementById('commentTaskId').value = taskId;
        const modal = new bootstrap.Modal(document.getElementById('addCommentModal'));
        modal.show();
    }

    // معالجة إرسال التعليق
    document.getElementById('addCommentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const taskId = formData.get('task_id');
        const comment = formData.get('comment');

        fetch(`/marketing/tasks/${taskId}/comment`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                comment: comment,
                is_internal: true
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // إغلاق المودال
                const modal = bootstrap.Modal.getInstance(document.getElementById('addCommentModal'));
                modal.hide();
                
                // مسح النموذج
                this.reset();
                
                // إظهار رسالة نجاح
                showAlert('success', 'تم إضافة التعليق بنجاح');
            } else {
                showAlert('error', 'حدث خطأ في إضافة التعليق');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('error', 'حدث خطأ في إضافة التعليق');
        });
    });

    // وظيفة إظهار التنبيهات
    function showAlert(type, message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
        alertDiv.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        // إضافة التنبيه في أعلى الصفحة
        const container = document.querySelector('.container-fluid');
        container.insertBefore(alertDiv, container.firstChild);
        
        // إزالة التنبيه تلقائياً بعد 5 ثوان
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }
</script>
@endpush
