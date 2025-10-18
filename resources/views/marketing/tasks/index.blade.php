@extends('layouts.dashboard')

@section('title', 'إدارة المهام - التسويق')
@section('dashboard-title', 'إدارة المهام')
@section('page-title', 'لوحة المهام')
@section('page-subtitle', 'نظام إدارة المهام لفريق التسويق')

@section('page-actions')
    <div class="d-flex gap-2">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTaskModal">
            <i class="fas fa-plus me-2"></i>
            مهمة جديدة
        </button>
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
                        <i class="{{ $board->board_icon }}" style="color: {{ $board->board_color }}"></i>
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
                                        <i class="{{ $column->column_icon }}" style="color: {{ $column->column_color }}"></i>
                                        <span>{{ $column->name }}</span>
                                        <span class="task-count">{{ $column->active_tasks_count }}</span>
                                    </div>
                                    <div class="column-actions">
                                        <button class="btn btn-sm btn-outline-primary" onclick="addTask({{ $column->id }})">
                                            <i class="fas fa-plus"></i>
                                        </button>
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
                                                        <div class="progress-bar" style="width: {{ $task->progress_percentage }}%"></div>
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
                                                    <div class="due-date {{ $task->is_overdue ? 'overdue' : ($task->is_due_soon ? 'due-soon' : '') }}">
                                                        <i class="fas fa-calendar"></i>
                                                        {{ $task->due_date->format('Y-m-d') }}
                                                    </div>
                                                @endif

                                                <div class="task-actions">
                                                    <button class="btn btn-sm btn-outline-primary" onclick="viewTask({{ $task->id }})">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-secondary" onclick="editTask({{ $task->id }})">
                                                        <i class="fas fa-edit"></i>
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

    <!-- Modal إنشاء مهمة جديدة -->
    <div class="modal fade" id="createTaskModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">إنشاء مهمة جديدة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="createTaskForm">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="taskTitle" class="form-label">عنوان المهمة</label>
                                    <input type="text" class="form-control" id="taskTitle" name="title" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="taskPriority" class="form-label">الأولوية</label>
                                    <select class="form-select" id="taskPriority" name="priority" required>
                                        <option value="low">منخفضة</option>
                                        <option value="medium" selected>متوسطة</option>
                                        <option value="high">عالية</option>
                                        <option value="urgent">عاجلة</option>
                                        <option value="critical">حرجة</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="taskDescription" class="form-label">الوصف</label>
                            <textarea class="form-control" id="taskDescription" name="description" rows="3"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="taskBoard" class="form-label">اللوحة</label>
                                    <select class="form-select" id="taskBoard" name="board_id" required>
                                        @foreach($boards as $board)
                                            <option value="{{ $board->id }}">{{ $board->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="taskColumn" class="form-label">العمود</label>
                                    <select class="form-select" id="taskColumn" name="column_id" required>
                                        @foreach($boards->first()->columns ?? [] as $column)
                                            <option value="{{ $column->id }}">{{ $column->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="taskDueDate" class="form-label">تاريخ الاستحقاق</label>
                                    <input type="date" class="form-control" id="taskDueDate" name="due_date">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="taskAssignedTo" class="form-label">تعيين إلى</label>
                                    <select class="form-select" id="taskAssignedTo" name="assigned_to">
                                        <option value="">اختر شخص</option>
                                        @foreach($users['admins'] as $admin)
                                            <option value="{{ $admin->id }}" data-type="admin">{{ $admin->name }}</option>
                                        @endforeach
                                        @foreach($users['marketing'] as $marketing)
                                            <option value="{{ $marketing->id }}" data-type="marketing">{{ $marketing->name }} (تسويق)</option>
                                        @endforeach
                                        @foreach($users['sales'] as $sales)
                                            <option value="{{ $sales->id }}" data-type="sales">{{ $sales->name }} (مبيعات)</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="taskEstimatedHours" class="form-label">الساعات المتوقعة</label>
                                    <input type="number" class="form-control" id="taskEstimatedHours" name="estimated_hours" step="0.5" min="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="taskColor" class="form-label">اللون</label>
                                    <input type="color" class="form-control form-control-color" id="taskColor" name="color">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">إنشاء المهمة</button>
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
</script>
@endpush
