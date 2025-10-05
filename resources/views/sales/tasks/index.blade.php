@extends('layouts.sales-dashboard')

@section('title', 'لوحة المهام - فريق المبيعات')
@section('dashboard-title', 'لوحة المهام')
@section('page-title', 'لوحة المهام')
@section('page-subtitle', 'إدارة وتتبع مهام فريق المبيعات بنظام Trello')

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
        <div class="sales-stats-card">
            <div class="d-flex align-items-center">
                <div class="sales-stats-icon primary">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0">{{ $tasks->total() }}</h3>
                    <p class="mb-0 text-muted">إجمالي المهام</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="sales-stats-card">
            <div class="d-flex align-items-center">
                <div class="sales-stats-icon warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0">{{ $tasks->where('status', 'pending')->count() }}</h3>
                    <p class="mb-0 text-muted">معلقة</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="sales-stats-card">
            <div class="d-flex align-items-center">
                <div class="sales-stats-icon info">
                    <i class="fas fa-play"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0">{{ $tasks->where('status', 'in_progress')->count() }}</h3>
                    <p class="mb-0 text-muted">قيد التنفيذ</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="sales-stats-card">
            <div class="d-flex align-items-center">
                <div class="sales-stats-icon success">
                    <i class="fas fa-check"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0">{{ $tasks->where('status', 'completed')->count() }}</h3>
                    <p class="mb-0 text-muted">مكتملة</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- لوحة Trello للمبيعات -->
<div class="sales-kanban-board">
    <div class="row g-4">
        <!-- عمود المهام المعلقة -->
        <div class="col-lg-4">
            <div class="sales-kanban-column" data-status="pending">
                <div class="sales-kanban-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-clock me-2 text-warning"></i>
                            <h6 class="mb-0">معلقة</h6>
                        </div>
                        <span class="sales-badge bg-warning">{{ $tasks->where('status', 'pending')->count() }}</span>
                    </div>
                </div>
                <div class="sales-kanban-body" data-status="pending">
                    @foreach($tasks->where('status', 'pending') as $task)
                        <div class="sales-task-card" data-task-id="{{ $task->id }}" data-status="pending" draggable="true">
                            <div class="sales-task-header">
                                <h6 class="sales-task-title">{{ $task->title }}</h6>
                                <div class="sales-task-actions">
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#salesTaskModal{{ $task->id }}">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="sales-task-content">
                                <p class="sales-task-description">{{ Str::limit($task->description, 80) }}</p>
                                <div class="sales-task-meta">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="fas fa-user me-1"></i>
                                            @if($task->assigned_to && $task->assignedTo && $task->assignedTo->user)
                                                {{ $task->assignedTo->user->name }}
                                            @else
                                                غير محدد
                                            @endif
                                        </small>
                                        @if($task->priority === 'high')
                                            <span class="sales-badge bg-danger">عاجل</span>
                                        @elseif($task->priority === 'medium')
                                            <span class="sales-badge bg-warning">متوسط</span>
                                        @elseif($task->priority === 'low')
                                            <span class="sales-badge bg-success">منخفض</span>
                                        @endif
                                    </div>
                                    @if($task->due_date)
                                        <small class="text-muted d-block mt-2">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $task->due_date->format('Y-m-d') }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- عمود المهام قيد التنفيذ -->
        <div class="col-lg-4">
            <div class="sales-kanban-column" data-status="in_progress">
                <div class="sales-kanban-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-play me-2 text-info"></i>
                            <h6 class="mb-0">قيد التنفيذ</h6>
                        </div>
                        <span class="sales-badge bg-info">{{ $tasks->where('status', 'in_progress')->count() }}</span>
                    </div>
                </div>
                <div class="sales-kanban-body" data-status="in_progress">
                    @foreach($tasks->where('status', 'in_progress') as $task)
                        <div class="sales-task-card" data-task-id="{{ $task->id }}" data-status="in_progress" draggable="true">
                            <div class="sales-task-header">
                                <h6 class="sales-task-title">{{ $task->title }}</h6>
                                <div class="sales-task-actions">
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#salesTaskModal{{ $task->id }}">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="sales-task-content">
                                <p class="sales-task-description">{{ Str::limit($task->description, 80) }}</p>
                                <div class="sales-task-meta">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="fas fa-user me-1"></i>
                                            @if($task->assigned_to && $task->assignedTo && $task->assignedTo->user)
                                                {{ $task->assignedTo->user->name }}
                                            @else
                                                غير محدد
                                            @endif
                                        </small>
                                        @if($task->priority === 'high')
                                            <span class="sales-badge bg-danger">عاجل</span>
                                        @elseif($task->priority === 'medium')
                                            <span class="sales-badge bg-warning">متوسط</span>
                                        @elseif($task->priority === 'low')
                                            <span class="sales-badge bg-success">منخفض</span>
                                        @endif
                                    </div>
                                    @if($task->due_date)
                                        <small class="text-muted d-block mt-2">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $task->due_date->format('Y-m-d') }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- عمود المهام المكتملة -->
        <div class="col-lg-4">
            <div class="sales-kanban-column" data-status="completed">
                <div class="sales-kanban-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check me-2 text-success"></i>
                            <h6 class="mb-0">مكتملة</h6>
                        </div>
                        <span class="sales-badge bg-success">{{ $tasks->where('status', 'completed')->count() }}</span>
                    </div>
                </div>
                <div class="sales-kanban-body" data-status="completed">
                    @foreach($tasks->where('status', 'completed') as $task)
                        <div class="sales-task-card" data-task-id="{{ $task->id }}" data-status="completed" draggable="true">
                            <div class="sales-task-header">
                                <h6 class="sales-task-title">{{ $task->title }}</h6>
                                <div class="sales-task-actions">
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#salesTaskModal{{ $task->id }}">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="sales-task-content">
                                <p class="sales-task-description">{{ Str::limit($task->description, 80) }}</p>
                                <div class="sales-task-meta">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="fas fa-user me-1"></i>
                                            @if($task->assigned_to && $task->assignedTo && $task->assignedTo->user)
                                                {{ $task->assignedTo->user->name }}
                                            @else
                                                غير محدد
                                            @endif
                                        </small>
                                        @if($task->priority === 'high')
                                            <span class="sales-badge bg-danger">عاجل</span>
                                        @elseif($task->priority === 'medium')
                                            <span class="sales-badge bg-warning">متوسط</span>
                                        @elseif($task->priority === 'low')
                                            <span class="sales-badge bg-success">منخفض</span>
                                        @endif
                                    </div>
                                    @if($task->due_date)
                                        <small class="text-muted d-block mt-2">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $task->due_date->format('Y-m-d') }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@if($tasks->count() === 0)
    <div class="text-center py-5">
        <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
        <h5 class="text-muted">لا توجد مهام حالياً</h5>
        <p class="text-muted">لم يتم تعيين أي مهام لفريق المبيعات بعد</p>
    </div>
@endif

<!-- Modal for Task Details -->
@foreach($tasks as $task)
<div class="modal fade" id="salesTaskModal{{ $task->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-tasks me-2"></i>
                    {{ $task->title }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>تفاصيل المهمة</h6>
                        <p class="text-muted">{{ $task->description }}</p>
                        
                        <h6 class="mt-3">الأولوية</h6>
                        @switch($task->priority)
                            @case('urgent')
                                <span class="sales-badge bg-danger">عاجل</span>
                                @break
                            @case('high')
                                <span class="sales-badge bg-warning">عالي</span>
                                @break
                            @case('medium')
                                <span class="sales-badge bg-info">متوسط</span>
                                @break
                            @case('low')
                                <span class="sales-badge bg-success">منخفض</span>
                                @break
                        @endswitch
                    </div>
                    <div class="col-md-6">
                        <h6>معلومات إضافية</h6>
                        <ul class="list-unstyled">
                            <li><strong>الحالة:</strong> 
                                @switch($task->status)
                                    @case('pending')
                                        <span class="sales-badge bg-warning">معلقة</span>
                                        @break
                                    @case('in_progress')
                                        <span class="sales-badge bg-info">قيد التنفيذ</span>
                                        @break
                                    @case('completed')
                                        <span class="sales-badge bg-success">مكتملة</span>
                                        @break
                                @endswitch
                            </li>
                            <li><strong>تاريخ الإنشاء:</strong> {{ $task->created_at->format('Y-m-d H:i') }}</li>
                            @if($task->due_date)
                                <li><strong>تاريخ الاستحقاق:</strong> {{ \Carbon\Carbon::parse($task->due_date)->format('Y-m-d H:i') }}</li>
                            @endif
                            @if($task->completed_at)
                                <li><strong>تاريخ الإكمال:</strong> {{ \Carbon\Carbon::parse($task->completed_at)->format('Y-m-d H:i') }}</li>
                            @endif
                        </ul>
                    </div>
                </div>
                
                @if($task->notes)
                    <div class="mt-3">
                        <h6>ملاحظات</h6>
                        <div class="alert alert-info">
                            {{ $task->notes }}
                        </div>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                @if($task->status !== 'completed')
                    <form action="{{ route('sales.tasks.update-status', $task) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <div class="d-flex gap-2">
                            @if($task->status === 'pending')
                                <input type="hidden" name="status" value="in_progress">
                                <button type="submit" class="btn btn-info">
                                    <i class="fas fa-play me-2"></i>بدء التنفيذ
                                </button>
                            @endif
                            @if($task->status === 'in_progress')
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check me-2"></i>إكمال المهمة
                                </button>
                            @endif
                        </div>
                    </form>
                @endif
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/sales-kanban.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/sales-kanban.js') }}"></script>
@endsection
