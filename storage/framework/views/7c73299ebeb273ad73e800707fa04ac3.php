

<?php $__env->startSection('title', 'إدارة المهام - التسويق'); ?>
<?php $__env->startSection('dashboard-title', 'إدارة المهام'); ?>
<?php $__env->startSection('page-title', 'لوحة المهام'); ?>
<?php $__env->startSection('page-subtitle', 'نظام إدارة المهام لفريق التسويق'); ?>

<?php $__env->startSection('page-actions'); ?>
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
<?php $__env->stopSection(); ?>

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
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="stats-card h-100">
                <div class="d-flex align-items-center">
                    <div class="stats-icon primary me-3">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <div>
                        <h3 class="mb-0"><?php echo e($stats['total_tasks']); ?></h3>
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
                        <h3 class="mb-0"><?php echo e($stats['completed_tasks']); ?></h3>
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
                        <h3 class="mb-0"><?php echo e($stats['in_progress_tasks']); ?></h3>
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
                        <h3 class="mb-0"><?php echo e($stats['pending_tasks']); ?></h3>
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
                        <h3 class="mb-0"><?php echo e($stats['overdue_tasks']); ?></h3>
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
                        <h3 class="mb-0"><?php echo e($stats['urgent_tasks']); ?></h3>
                        <p class="text-muted mb-0">عاجلة</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- لوحات المهام -->
    <div class="task-boards-container">
        <?php $__currentLoopData = $boards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $board): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="task-board" data-board-id="<?php echo e($board->id); ?>">
                <div class="board-header">
                    <div class="board-title">
                        <i class="<?php echo e($board->board_icon); ?>" style="color: <?php echo e($board->board_color ?? '#6c757d'); ?>"></i>
                        <h4><?php echo e($board->name); ?></h4>
                        <span class="badge bg-secondary"><?php echo e($board->board_type_label); ?></span>
                    </div>
                </div>

                <div class="board-content">
                    <div class="columns-container" id="board-<?php echo e($board->id); ?>-columns">
                        <?php $__currentLoopData = $board->columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="task-column" data-column-id="<?php echo e($column->id); ?>" data-board-id="<?php echo e($board->id); ?>">
                                <div class="column-header">
                                    <div class="column-title">
                                        <i class="<?php echo e($column->column_icon); ?>" style="color: <?php echo e($column->column_color ?? '#6c757d'); ?>"></i>
                                        <span><?php echo e($column->name); ?></span>
                                        <span class="task-count"><?php echo e($column->active_tasks_count); ?></span>
                                    </div>
                                    <div class="column-actions">
                                        <span class="badge bg-light text-dark">فريق التسويق</span>
                                    </div>
                                </div>

                                <div class="column-content" id="column-<?php echo e($column->id); ?>-tasks">
                                    <?php $__currentLoopData = $column->tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="task-card" data-task-id="<?php echo e($task->id); ?>" draggable="true">
                                            <div class="task-header">
                                                <div class="task-priority priority-<?php echo e($task->priority); ?>"></div>
                                                <?php if($task->is_urgent): ?>
                                                    <i class="fas fa-fire text-danger"></i>
                                                <?php endif; ?>
                                                <?php if($task->is_overdue): ?>
                                                    <i class="fas fa-exclamation-triangle text-warning"></i>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="task-title"><?php echo e($task->title); ?></div>
                                            
                                            <?php if($task->description): ?>
                                                <div class="task-description"><?php echo e(Str::limit($task->description, 100)); ?></div>
                                            <?php endif; ?>

                                            <?php if($task->labels && count($task->labels) > 0): ?>
                                                <div class="task-labels">
                                                    <?php $__currentLoopData = $task->labels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <span class="label" style="background-color: <?php echo e($label['color'] ?? '#6c757d'); ?>">
                                                            <?php echo e($label['name']); ?>

                                                        </span>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            <?php endif; ?>

                                            <?php if($task->checklist && count($task->checklist) > 0): ?>
                                                <div class="task-progress">
                                                    <div class="progress">
                                                        <div class="progress-bar" style="width: <?php echo e($task->progress_percentage ?? 0); ?>%"></div>
                                                    </div>
                                                    <small class="text-muted"><?php echo e($task->progress_percentage); ?>%</small>
                                                </div>
                                            <?php endif; ?>

                                            <div class="task-footer">
                                                <?php if($task->assignedUser): ?>
                                                    <div class="assigned-user">
                                                        <i class="fas fa-user"></i>
                                                        <?php echo e($task->assignedUser->name); ?>

                                                    </div>
                                                <?php endif; ?>
                                                
                                                <?php if($task->due_date): ?>
                                                    <div class="due-date <?php if($task->is_overdue): ?> overdue <?php elseif($task->is_due_soon): ?> due-soon <?php endif; ?>">
                                                        <i class="fas fa-calendar"></i>
                                                        <?php echo e($task->due_date->format('Y-m-d')); ?>

                                                    </div>
                                                <?php endif; ?>

                                                <div class="task-actions">
                                                    <button class="btn btn-sm btn-outline-primary" data-task-id="<?php echo e($task->id); ?>" onclick="viewTask(this.dataset.taskId)" title="عرض التفاصيل">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-info" data-task-id="<?php echo e($task->id); ?>" onclick="addComment(this.dataset.taskId)" title="إضافة تعليق">
                                                        <i class="fas fa-comment"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/task-management.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/task-management.js')); ?>"></script>
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\marketing\tasks\index.blade.php ENDPATH**/ ?>