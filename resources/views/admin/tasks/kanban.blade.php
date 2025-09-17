@extends('layouts.dashboard')

@section('title', 'لوحة المهام - Kanban')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active">لوحة المهام</li>
                    </ol>
                </div>
                <h4 class="page-title">
                    <i class="fas fa-columns me-2"></i>
                    لوحة المهام - Kanban
                </h4>
            </div>
        </div>
    </div>

    <!-- شريط الأدوات -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex gap-2">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTaskModal">
                                <i class="fas fa-plus me-2"></i>
                                مهمة جديدة
                            </button>
                            <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#createBoardModal">
                                <i class="fas fa-plus-square me-2"></i>
                                لوحة جديدة
                            </button>
                            <div class="dropdown">
                                <button class="btn btn-outline-info dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-filter me-2"></i>
                                    تصفية
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" onclick="filterByUser('all')">جميع المستخدمين</a></li>
                                    @foreach($users as $user)
                                        <li><a class="dropdown-item" href="#" onclick="filterByUser({{ $user->id }})">{{ $user->name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-success" onclick="toggleView('compact')">
                                <i class="fas fa-compress me-2"></i>
                                عرض مضغوط
                            </button>
                            <button class="btn btn-outline-warning" onclick="exportBoard()">
                                <i class="fas fa-download me-2"></i>
                                تصدير
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- لوحات المهام -->
    <div class="row" id="kanban-boards">
        @foreach($boards as $board)
            <div class="col-12 mb-4">
                <div class="card board-card" data-board-id="{{ $board->id }}">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0">
                                    <i class="fas fa-columns me-2"></i>
                                    {{ $board->name }}
                                </h5>
                                @if($board->description)
                                    <small class="opacity-75">{{ $board->description }}</small>
                                @endif
                            </div>
                            <div class="d-flex gap-2">
                                <span class="badge bg-light text-dark">{{ $board->stats['total'] }} مهمة</span>
                                <button class="btn btn-sm btn-outline-light" onclick="editBoard({{ $board->id }})">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="row g-0">
                            @php
                                $columns = \App\Models\TaskBoard::getColumns();
                            @endphp
                            @foreach($columns as $columnKey => $column)
                                <div class="col-lg-3 col-md-6">
                                    <div class="kanban-column" data-column="{{ $columnKey }}" data-board-id="{{ $board->id }}">
                                        <div class="column-header" style="background-color: {{ $column['color'] }}20; border-left: 4px solid {{ $column['color'] }}">
                                            <div class="d-flex justify-content-between align-items-center p-3">
                                                <div>
                                                    <h6 class="mb-0">
                                                        <i class="{{ $column['icon'] }} me-2"></i>
                                                        {{ $column['name'] }}
                                                    </h6>
                                                    <small class="text-muted">{{ $board->tasksInColumn($columnKey)->count() }} مهمة</small>
                                                </div>
                                                <button class="btn btn-sm btn-outline-primary" onclick="addTaskToColumn('{{ $columnKey }}', {{ $board->id }})">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="column-body p-2" style="min-height: 400px;">
                                            @foreach($board->tasksInColumn($columnKey) as $task)
                                                <div class="task-card" 
                                                     data-task-id="{{ $task->id }}" 
                                                     data-position="{{ $task->position }}"
                                                     draggable="true"
                                                     style="border-left: 4px solid {{ $task->color }}">
                                                    <div class="card mb-2">
                                                        <div class="card-body p-3">
                                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                                <h6 class="card-title mb-0">{{ $task->title }}</h6>
                                                                <div class="dropdown">
                                                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown">
                                                                        <i class="fas fa-ellipsis-v"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a class="dropdown-item" href="#" onclick="editTask({{ $task->id }})">
                                                                            <i class="fas fa-edit me-2"></i>تعديل
                                                                        </a></li>
                                                                        <li><a class="dropdown-item" href="#" onclick="viewTask({{ $task->id }})">
                                                                            <i class="fas fa-eye me-2"></i>عرض التفاصيل
                                                                        </a></li>
                                                                        <li><hr class="dropdown-divider"></li>
                                                                        <li><a class="dropdown-item text-danger" href="#" onclick="deleteTask({{ $task->id }})">
                                                                            <i class="fas fa-trash me-2"></i>حذف
                                                                        </a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            
                                                            @if($task->description)
                                                                <p class="card-text small text-muted mb-2">
                                                                    {{ Str::limit($task->description, 100) }}
                                                                </p>
                                                            @endif

                                                            <!-- التسميات -->
                                                            @if($task->labels && count($task->labels) > 0)
                                                                <div class="mb-2">
                                                                    @foreach($task->labels as $label)
                                                                        <span class="badge bg-secondary me-1">{{ $label['name'] }}</span>
                                                                    @endforeach
                                                                </div>
                                                            @endif

                                                            <!-- معلومات المهمة -->
                                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                                <div class="d-flex gap-1">
                                                                    @if($task->priority === 'high' || $task->priority === 'urgent')
                                                                        <span class="badge bg-danger">
                                                                            <i class="fas fa-exclamation-triangle"></i>
                                                                        </span>
                                                                    @elseif($task->priority === 'medium')
                                                                        <span class="badge bg-warning">
                                                                            <i class="fas fa-exclamation"></i>
                                                                        </span>
                                                                    @else
                                                                        <span class="badge bg-info">
                                                                            <i class="fas fa-info"></i>
                                                                        </span>
                                                                    @endif
                                                                    
                                                                    @if($task->due_date)
                                                                        <span class="badge {{ $task->is_overdue ? 'bg-danger' : 'bg-secondary' }}">
                                                                            <i class="fas fa-calendar me-1"></i>
                                                                            {{ $task->due_date->format('d/m') }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                                
                                                                @if($task->estimated_hours)
                                                                    <small class="text-muted">
                                                                        <i class="fas fa-clock me-1"></i>
                                                                        {{ $task->estimated_hours }}h
                                                                    </small>
                                                                @endif
                                                            </div>

                                                            <!-- شريط التقدم -->
                                                            @if($task->checklist && count($task->checklist) > 0)
                                                                <div class="mb-2">
                                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                                        <small class="text-muted">التقدم</small>
                                                                        <small class="text-muted">{{ $task->progress_percentage }}%</small>
                                                                    </div>
                                                                    <div class="progress" style="height: 4px;">
                                                                        <div class="progress-bar" style="width: {{ $task->progress_percentage }}%"></div>
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            <!-- المستخدم المعين -->
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar me-2">
                                                                        <div class="avatar-initial bg-primary rounded-circle">
                                                                            {{ substr($task->assignedUser->name ?? 'غير محدد', 0, 1) }}
                                                                        </div>
                                                                    </div>
                                                                    <small class="text-muted">{{ $task->assignedUser->name ?? 'غير محدد' }}</small>
                                                                </div>
                                                                
                                                                @if($task->comments && count($task->comments) > 0)
                                                                    <small class="text-muted">
                                                                        <i class="fas fa-comment me-1"></i>
                                                                        {{ count($task->comments) }}
                                                                    </small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Modal إنشاء مهمة جديدة -->
<div class="modal fade" id="createTaskModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>
                    مهمة جديدة
                </h5>
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
                                <label for="taskBoard" class="form-label">اللوحة</label>
                                <select class="form-select" id="taskBoard" name="board_id" required>
                                    @foreach($boards as $board)
                                        <option value="{{ $board->id }}">{{ $board->name }}</option>
                                    @endforeach
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
                                <label for="taskAssignedTo" class="form-label">المكلف</label>
                                <select class="form-select" id="taskAssignedTo" name="assigned_to" required>
                                    <option value="" data-type="">-- اختر المستخدم المكلف --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" data-type="{{ $user->user_type }}">
                                            {{ $user->name }} ({{ $user->user_type === 'admin' ? 'إداري' : ($user->user_type === 'sales' ? 'مبيعات' : 'تسويق') }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="taskPriority" class="form-label">الأولوية</label>
                                <select class="form-select" id="taskPriority" name="priority" required>
                                    <option value="low">منخفضة</option>
                                    <option value="medium" selected>متوسطة</option>
                                    <option value="high">عالية</option>
                                    <option value="urgent">عاجلة</option>
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
                                <label for="taskEstimatedHours" class="form-label">الساعات المتوقعة</label>
                                <input type="number" class="form-control" id="taskEstimatedHours" name="estimated_hours" min="0" step="0.5">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="taskColor" class="form-label">لون المهمة</label>
                        <input type="color" class="form-control form-control-color" id="taskColor" name="color" value="#007bff">
                    </div>
                    
                    <!-- حقل مخفي لنوع المستخدم -->
                    <input type="hidden" id="assignedToType" name="assigned_to_type" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        إنشاء المهمة
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal إنشاء لوحة جديدة -->
<div class="modal fade" id="createBoardModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus-square me-2"></i>
                    لوحة مهام جديدة
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createBoardForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="boardName" class="form-label">اسم اللوحة</label>
                        <input type="text" class="form-control" id="boardName" name="name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="boardDescription" class="form-label">الوصف</label>
                        <textarea class="form-control" id="boardDescription" name="description" rows="3"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="boardType" class="form-label">نوع اللوحة</label>
                        <select class="form-select" id="boardType" name="type" required>
                            <option value="general">عام</option>
                            <option value="marketing">تسويق</option>
                            <option value="sales">مبيعات</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        إنشاء اللوحة
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.kanban-column {
    border-right: 1px solid #dee2e6;
    min-height: 500px;
}

.column-header {
    border-bottom: 1px solid #dee2e6;
}

.column-body {
    background-color: #f8f9fa;
    min-height: 400px;
}

.task-card {
    cursor: move;
    transition: all 0.3s ease;
}

.task-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.task-card.dragging {
    opacity: 0.5;
    transform: rotate(5deg);
}

.column-body.drag-over {
    background-color: #e3f2fd;
    border: 2px dashed #2196f3;
}

.avatar-initial {
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    color: white;
    font-size: 0.75rem;
}

.board-card {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    overflow: hidden;
}

.progress {
    background-color: #e9ecef;
}

.progress-bar {
    background-color: #28a745;
    transition: width 0.3s ease;
}

@media (max-width: 768px) {
    .kanban-column {
        border-right: none;
        border-bottom: 1px solid #dee2e6;
        margin-bottom: 1rem;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
let sortableInstances = [];

// تهيئة السحب والإفلات
document.addEventListener('DOMContentLoaded', function() {
    initializeSortable();
    setupEventListeners();
    
    // تهيئة نوع المستخدم الأول (تخطي الخيار الفارغ)
    const firstUser = document.getElementById('taskAssignedTo');
    if (firstUser && firstUser.options.length > 1) {
        const firstOption = firstUser.options[1]; // الخيار الثاني (تخطي الفارغ)
        window.selectedUserType = firstOption.dataset.type;
        document.getElementById('assignedToType').value = firstOption.dataset.type;
    }
});

function initializeSortable() {
    document.querySelectorAll('.column-body').forEach(columnBody => {
        const sortable = Sortable.create(columnBody, {
            group: 'kanban',
            animation: 150,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            onEnd: function(evt) {
                const taskId = evt.item.dataset.taskId;
                const newColumn = evt.to.dataset.column;
                const newBoardId = evt.to.dataset.boardId;
                const newPosition = evt.newIndex;
                
                updateTaskPosition(taskId, newColumn, newPosition, newBoardId);
            }
        });
        
        sortableInstances.push(sortable);
    });
}

function setupEventListeners() {
    // إنشاء مهمة جديدة
    document.getElementById('createTaskForm').addEventListener('submit', function(e) {
        e.preventDefault();
        createTask();
    });
    
    // إنشاء لوحة جديدة
    document.getElementById('createBoardForm').addEventListener('submit', function(e) {
        e.preventDefault();
        createBoard();
    });
    
    // إعادة تعيين النموذج عند إغلاق المودال
    document.getElementById('createTaskModal').addEventListener('hidden.bs.modal', function() {
        document.getElementById('createTaskForm').reset();
        // إعادة تعيين نوع المستخدم
        const firstUser = document.getElementById('taskAssignedTo');
        if (firstUser && firstUser.options.length > 1) {
            const firstOption = firstUser.options[1];
            window.selectedUserType = firstOption.dataset.type;
            document.getElementById('assignedToType').value = firstOption.dataset.type;
        }
    });
    
    // تحديث نوع المستخدم المعين
    document.getElementById('taskAssignedTo').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const userType = selectedOption.dataset.type;
        // تخزين نوع المستخدم في متغير عام وفي الحقل المخفي
        window.selectedUserType = userType;
        document.getElementById('assignedToType').value = userType;
    });
}

function updateTaskPosition(taskId, columnStatus, position, boardId) {
    fetch(`/admin/tasks/${taskId}/position`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            task_id: taskId,
            column_status: columnStatus,
            position: position,
            board_id: boardId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('تم تحديث موضع المهمة بنجاح', 'success');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('حدث خطأ أثناء تحديث موضع المهمة', 'error');
    });
}

function createTask() {
    const formData = new FormData(document.getElementById('createTaskForm'));
    
    // التحقق من وجود المستخدم المختار
    if (!formData.get('assigned_to') || formData.get('assigned_to') === '') {
        showNotification('يرجى اختيار المستخدم المكلف', 'error');
        document.getElementById('taskAssignedTo').focus();
        return;
    }
    
    // التحقق من وجود نوع المستخدم
    if (!formData.get('assigned_to_type') || formData.get('assigned_to_type') === '') {
        showNotification('خطأ في تحديد نوع المستخدم', 'error');
        return;
    }
    
    const data = {
        title: formData.get('title'),
        description: formData.get('description'),
        board_id: formData.get('board_id'),
        assigned_to: formData.get('assigned_to'),
        assigned_to_type: formData.get('assigned_to_type'),
        priority: formData.get('priority'),
        due_date: formData.get('due_date'),
        estimated_hours: formData.get('estimated_hours'),
        color: formData.get('color')
    };
    
    fetch('/admin/tasks', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('تم إنشاء المهمة بنجاح', 'success');
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('حدث خطأ أثناء إنشاء المهمة', 'error');
    });
}

function createBoard() {
    const formData = new FormData(document.getElementById('createBoardForm'));
    
    const data = {
        name: formData.get('name'),
        description: formData.get('description'),
        type: formData.get('type')
    };
    
    fetch('/admin/tasks/board', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('تم إنشاء اللوحة بنجاح', 'success');
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('حدث خطأ أثناء إنشاء اللوحة', 'error');
    });
}

function editTask(taskId) {
    // TODO: Implement task editing modal
    showNotification('ميزة التعديل قيد التطوير', 'info');
}

function viewTask(taskId) {
    // TODO: Implement task details modal
    showNotification('ميزة عرض التفاصيل قيد التطوير', 'info');
}

function deleteTask(taskId) {
    if (confirm('هل أنت متأكد من حذف هذه المهمة؟')) {
        fetch(`/admin/tasks/${taskId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('تم حذف المهمة بنجاح', 'success');
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('حدث خطأ أثناء حذف المهمة', 'error');
        });
    }
}

function addTaskToColumn(column, boardId) {
    document.getElementById('taskBoard').value = boardId;
    // TODO: Set default column in form
    document.getElementById('createTaskModal').querySelector('.modal').modal('show');
}

function filterByUser(userId) {
    // TODO: Implement user filtering
    showNotification('ميزة التصفية قيد التطوير', 'info');
}

function toggleView(viewType) {
    // TODO: Implement view toggle
    showNotification('ميزة تغيير العرض قيد التطوير', 'info');
}

function exportBoard() {
    // TODO: Implement board export
    showNotification('ميزة التصدير قيد التطوير', 'info');
}

function showNotification(message, type = 'info') {
    const alertClass = type === 'success' ? 'alert-success' : 
                      type === 'error' ? 'alert-danger' : 'alert-info';
    
    const notification = document.createElement('div');
    notification.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 5000);
}
</script>
@endpush