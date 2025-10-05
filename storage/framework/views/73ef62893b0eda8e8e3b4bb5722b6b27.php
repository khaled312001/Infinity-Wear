

<?php $__env->startSection('title', 'لوحة المهام - فريق المبيعات'); ?>
<?php $__env->startSection('dashboard-title', 'لوحة المهام'); ?>
<?php $__env->startSection('page-title', 'لوحة المهام'); ?>
<?php $__env->startSection('page-subtitle', 'إدارة وتتبع مهام فريق المبيعات بنظام Trello'); ?>

<?php $__env->startSection('content'); ?>
<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        <?php echo e(session('error')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- إحصائيات سريعة -->
<div class="row g-4 mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon primary">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0"><?php echo e($tasks->total()); ?></h3>
                    <p class="mb-0 text-muted">إجمالي المهام</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0"><?php echo e($tasks->where('status', 'pending')->count()); ?></h3>
                    <p class="mb-0 text-muted">معلقة</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon info">
                    <i class="fas fa-play"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0"><?php echo e($tasks->where('status', 'in_progress')->count()); ?></h3>
                    <p class="mb-0 text-muted">قيد التنفيذ</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon success">
                    <i class="fas fa-check"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0"><?php echo e($tasks->where('status', 'completed')->count()); ?></h3>
                    <p class="mb-0 text-muted">مكتملة</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- لوحة Trello -->
<div class="trello-board">
    <div class="row g-4">
        <!-- عمود المهام المعلقة -->
        <div class="col-lg-4">
            <div class="trello-column" data-status="pending">
                <div class="trello-column-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-clock me-2 text-warning"></i>
                            <h6 class="mb-0">معلقة</h6>
                        </div>
                        <span class="badge bg-warning"><?php echo e($tasks->where('status', 'pending')->count()); ?></span>
                    </div>
                </div>
                <div class="trello-column-body" data-status="pending">
                    <?php $__currentLoopData = $tasks->where('status', 'pending'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="trello-card" data-task-id="<?php echo e($task->id); ?>" data-status="pending" draggable="true">
                            <div class="trello-card-header">
                                <h6 class="trello-card-title"><?php echo e($task->title); ?></h6>
                                <div class="trello-card-actions">
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#taskModal<?php echo e($task->id); ?>">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="trello-card-body">
                                <p class="trello-card-description"><?php echo e(Str::limit($task->description, 80)); ?></p>
                                <div class="trello-card-meta">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="fas fa-user me-1"></i>
                                            <?php if($task->assigned_to && $task->assignedTo && $task->assignedTo->user): ?>
                                                <?php echo e($task->assignedTo->user->name); ?>

                                            <?php else: ?>
                                                غير محدد
                                            <?php endif; ?>
                                        </small>
                                        <?php if($task->priority === 'high'): ?>
                                            <span class="badge bg-danger">عاجل</span>
                                        <?php elseif($task->priority === 'medium'): ?>
                                            <span class="badge bg-warning">متوسط</span>
                                        <?php elseif($task->priority === 'low'): ?>
                                            <span class="badge bg-success">منخفض</span>
                                        <?php endif; ?>
                                    </div>
                                    <?php if($task->due_date): ?>
                                        <small class="text-muted d-block mt-2">
                                            <i class="fas fa-calendar me-1"></i>
                                            <?php echo e($task->due_date->format('Y-m-d')); ?>

                                        </small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

        <!-- عمود المهام قيد التنفيذ -->
        <div class="col-lg-4">
            <div class="trello-column" data-status="in_progress">
                <div class="trello-column-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-play me-2 text-info"></i>
                            <h6 class="mb-0">قيد التنفيذ</h6>
                        </div>
                        <span class="badge bg-info"><?php echo e($tasks->where('status', 'in_progress')->count()); ?></span>
                    </div>
                </div>
                <div class="trello-column-body" data-status="in_progress">
                    <?php $__currentLoopData = $tasks->where('status', 'in_progress'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="trello-card" data-task-id="<?php echo e($task->id); ?>" data-status="in_progress" draggable="true">
                            <div class="trello-card-header">
                                <h6 class="trello-card-title"><?php echo e($task->title); ?></h6>
                                <div class="trello-card-actions">
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#taskModal<?php echo e($task->id); ?>">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="trello-card-body">
                                <p class="trello-card-description"><?php echo e(Str::limit($task->description, 80)); ?></p>
                                <div class="trello-card-meta">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="fas fa-user me-1"></i>
                                            <?php if($task->assigned_to && $task->assignedTo && $task->assignedTo->user): ?>
                                                <?php echo e($task->assignedTo->user->name); ?>

                                            <?php else: ?>
                                                غير محدد
                                            <?php endif; ?>
                                        </small>
                                        <?php if($task->priority === 'high'): ?>
                                            <span class="badge bg-danger">عاجل</span>
                                        <?php elseif($task->priority === 'medium'): ?>
                                            <span class="badge bg-warning">متوسط</span>
                                        <?php elseif($task->priority === 'low'): ?>
                                            <span class="badge bg-success">منخفض</span>
                                        <?php endif; ?>
                                    </div>
                                    <?php if($task->due_date): ?>
                                        <small class="text-muted d-block mt-2">
                                            <i class="fas fa-calendar me-1"></i>
                                            <?php echo e($task->due_date->format('Y-m-d')); ?>

                                        </small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

        <!-- عمود المهام المكتملة -->
        <div class="col-lg-4">
            <div class="trello-column" data-status="completed">
                <div class="trello-column-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check me-2 text-success"></i>
                            <h6 class="mb-0">مكتملة</h6>
                        </div>
                        <span class="badge bg-success"><?php echo e($tasks->where('status', 'completed')->count()); ?></span>
                    </div>
                </div>
                <div class="trello-column-body" data-status="completed">
                    <?php $__currentLoopData = $tasks->where('status', 'completed'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="trello-card" data-task-id="<?php echo e($task->id); ?>" data-status="completed" draggable="true">
                            <div class="trello-card-header">
                                <h6 class="trello-card-title"><?php echo e($task->title); ?></h6>
                                <div class="trello-card-actions">
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#taskModal<?php echo e($task->id); ?>">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="trello-card-body">
                                <p class="trello-card-description"><?php echo e(Str::limit($task->description, 80)); ?></p>
                                <div class="trello-card-meta">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="fas fa-user me-1"></i>
                                            <?php if($task->assigned_to && $task->assignedTo && $task->assignedTo->user): ?>
                                                <?php echo e($task->assignedTo->user->name); ?>

                                            <?php else: ?>
                                                غير محدد
                                            <?php endif; ?>
                                        </small>
                                        <?php if($task->priority === 'high'): ?>
                                            <span class="badge bg-danger">عاجل</span>
                                        <?php elseif($task->priority === 'medium'): ?>
                                            <span class="badge bg-warning">متوسط</span>
                                        <?php elseif($task->priority === 'low'): ?>
                                            <span class="badge bg-success">منخفض</span>
                                        <?php endif; ?>
                                    </div>
                                    <?php if($task->due_date): ?>
                                        <small class="text-muted d-block mt-2">
                                            <i class="fas fa-calendar me-1"></i>
                                            <?php echo e($task->due_date->format('Y-m-d')); ?>

                                        </small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if($tasks->count() === 0): ?>
    <div class="text-center py-5">
        <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
        <h5 class="text-muted">لا توجد مهام حالياً</h5>
        <p class="text-muted">لم يتم تعيين أي مهام لفريق المبيعات بعد</p>
    </div>
<?php endif; ?>

<!-- Modal for Task Details -->
<?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="taskModal<?php echo e($task->id); ?>" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-tasks me-2"></i>
                    <?php echo e($task->title); ?>

                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>تفاصيل المهمة</h6>
                        <p class="text-muted"><?php echo e($task->description); ?></p>
                        
                        <h6 class="mt-3">الأولوية</h6>
                        <?php switch($task->priority):
                            case ('urgent'): ?>
                                <span class="badge bg-danger">عاجل</span>
                                <?php break; ?>
                            <?php case ('high'): ?>
                                <span class="badge bg-warning">عالي</span>
                                <?php break; ?>
                            <?php case ('medium'): ?>
                                <span class="badge bg-info">متوسط</span>
                                <?php break; ?>
                            <?php case ('low'): ?>
                                <span class="badge bg-success">منخفض</span>
                                <?php break; ?>
                        <?php endswitch; ?>
                    </div>
                    <div class="col-md-6">
                        <h6>معلومات إضافية</h6>
                        <ul class="list-unstyled">
                            <li><strong>الحالة:</strong> 
                                <?php switch($task->status):
                                    case ('pending'): ?>
                                        <span class="badge bg-warning">معلقة</span>
                                        <?php break; ?>
                                    <?php case ('in_progress'): ?>
                                        <span class="badge bg-info">قيد التنفيذ</span>
                                        <?php break; ?>
                                    <?php case ('completed'): ?>
                                        <span class="badge bg-success">مكتملة</span>
                                        <?php break; ?>
                                <?php endswitch; ?>
                            </li>
                            <li><strong>تاريخ الإنشاء:</strong> <?php echo e($task->created_at->format('Y-m-d H:i')); ?></li>
                            <?php if($task->due_date): ?>
                                <li><strong>تاريخ الاستحقاق:</strong> <?php echo e(\Carbon\Carbon::parse($task->due_date)->format('Y-m-d H:i')); ?></li>
                            <?php endif; ?>
                            <?php if($task->completed_at): ?>
                                <li><strong>تاريخ الإكمال:</strong> <?php echo e(\Carbon\Carbon::parse($task->completed_at)->format('Y-m-d H:i')); ?></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                
                <?php if($task->notes): ?>
                    <div class="mt-3">
                        <h6>ملاحظات</h6>
                        <div class="alert alert-info">
                            <?php echo e($task->notes); ?>

                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <?php if($task->status !== 'completed'): ?>
                    <form action="<?php echo e(route('sales.tasks.update-status', $task)); ?>" method="POST" class="d-inline">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="d-flex gap-2">
                            <?php if($task->status === 'pending'): ?>
                                <input type="hidden" name="status" value="in_progress">
                                <button type="submit" class="btn btn-info">
                                    <i class="fas fa-play me-2"></i>بدء التنفيذ
                                </button>
                            <?php endif; ?>
                            <?php if($task->status === 'in_progress'): ?>
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check me-2"></i>إكمال المهمة
                                </button>
                            <?php endif; ?>
                        </div>
                    </form>
                <?php endif; ?>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/trello-board.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('js/trello-drag-drop.js')); ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Trello Drag and Drop for Sales
    window.salesTrello = new TrelloDragDrop({
        updateUrl: '/sales/tasks/{taskId}/status',
        onStatusUpdate: function(taskId, newStatus, data) {
            console.log('Sales task status updated:', taskId, newStatus, data);
        },
        onError: function(error) {
            console.error('Sales Trello Error:', error);
        }
    });
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.sales-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views/sales/tasks/index.blade.php ENDPATH**/ ?>