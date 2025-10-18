<?php $__env->startSection('title', 'عرض الخطة - ' . $companyPlan->title); ?>
<?php $__env->startSection('dashboard-title', 'لوحة الإدارة'); ?>
<?php $__env->startSection('page-title', 'عرض الخطة'); ?>
<?php $__env->startSection('page-subtitle', $companyPlan->title); ?>

<?php $__env->startSection('sidebar-menu'); ?>
    <?php echo $__env->make('partials.admin-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-actions'); ?>
    <a href="<?php echo e(route('admin.company-plans.edit', $companyPlan)); ?>" class="btn btn-primary">
        <i class="fas fa-edit me-2"></i>
        تعديل الخطة
    </a>
    <a href="<?php echo e(route('admin.company-plans.index')); ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-right me-2"></i>
        العودة للقائمة
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <!-- معلومات الخطة الأساسية -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-line me-2 text-primary"></i>
                            <?php echo e($companyPlan->title); ?>

                        </h5>
                        <div>
                            <span class="badge bg-<?php echo e($companyPlan->status_color); ?> fs-6"><?php echo e($companyPlan->status_label); ?></span>
                            <span class="badge bg-info fs-6"><?php echo e($companyPlan->type_label); ?></span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php if($companyPlan->description): ?>
                        <p class="text-muted mb-3"><?php echo e($companyPlan->description); ?></p>
                    <?php endif; ?>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong>تاريخ البداية:</strong>
                                <span class="text-primary"><?php echo e($companyPlan->start_date->format('Y-m-d')); ?></span>
                            </div>
                            <div class="mb-3">
                                <strong>تاريخ النهاية:</strong>
                                <span class="text-primary"><?php echo e($companyPlan->end_date->format('Y-m-d')); ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong>المسؤول عن الخطة:</strong>
                                <span class="text-primary"><?php echo e($companyPlan->assignee->name ?? 'غير محدد'); ?></span>
                            </div>
                            <div class="mb-3">
                                <strong>منشئ الخطة:</strong>
                                <span class="text-primary"><?php echo e($companyPlan->creator->name ?? 'غير محدد'); ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <?php if($companyPlan->notes): ?>
                        <div class="alert alert-info">
                            <strong>ملاحظات:</strong><br>
                            <?php echo e($companyPlan->notes); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- إحصائيات سريعة -->
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">
                        <i class="fas fa-chart-pie me-2 text-primary"></i>
                        إحصائيات الخطة
                    </h6>
                </div>
                <div class="card-body">
                    <!-- التقدم -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>التقدم</span>
                            <span><?php echo e($companyPlan->progress_percentage); ?>%</span>
                        </div>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar bg-<?php echo e($companyPlan->progress_percentage >= 100 ? 'success' : ($companyPlan->progress_percentage >= 75 ? 'info' : ($companyPlan->progress_percentage >= 50 ? 'warning' : 'danger'))); ?>" 
                                 role="progressbar" 
                                 style="width: <?php echo e($companyPlan->progress_percentage); ?>%">
                                <?php echo e($companyPlan->progress_percentage); ?>%
                            </div>
                        </div>
                    </div>
                    
                    <!-- الأيام المتبقية -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>الأيام المتبقية:</span>
                            <span class="text-<?php echo e($companyPlan->days_remaining > 30 ? 'success' : ($companyPlan->days_remaining > 7 ? 'warning' : 'danger')); ?>">
                                <?php echo e($companyPlan->days_remaining); ?> يوم
                            </span>
                        </div>
                    </div>
                    
                    <!-- الميزانية -->
                    <?php if($companyPlan->budget): ?>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span>الميزانية:</span>
                                <span class="text-primary"><?php echo e(number_format($companyPlan->budget, 2)); ?> ر.س</span>
                            </div>
                            <?php if($companyPlan->actual_cost): ?>
                                <div class="d-flex justify-content-between">
                                    <span>التكلفة الفعلية:</span>
                                    <span class="text-<?php echo e($companyPlan->cost_percentage > 100 ? 'danger' : 'success'); ?>">
                                        <?php echo e(number_format($companyPlan->actual_cost, 2)); ?> ر.س
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>نسبة التكلفة:</span>
                                    <span class="text-<?php echo e($companyPlan->cost_percentage > 100 ? 'danger' : 'success'); ?>">
                                        <?php echo e($companyPlan->cost_percentage); ?>%
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($companyPlan->is_overdue): ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            هذه الخطة متأخرة عن الموعد المحدد
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- الأهداف -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">
                        <i class="fas fa-bullseye me-2 text-primary"></i>
                        الأهداف الاستراتيجية
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php $__currentLoopData = $companyPlan->objectives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $objective): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <div class="me-3">
                                    <span class="badge bg-primary rounded-circle"><?php echo e($index + 1); ?></span>
                                </div>
                                <div>
                                    <p class="mb-0"><?php echo e($objective); ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- تحليل SWOT -->
    <div class="row mb-4">
        <div class="col-12">
            <h5 class="text-primary mb-3">
                <i class="fas fa-chart-pie me-2"></i>
                تحليل SWOT
            </h5>
        </div>
    </div>
    
    <div class="row">
        <!-- نقاط القوة -->
        <div class="col-md-6 mb-4">
            <div class="card border-success h-100">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-thumbs-up me-2"></i>
                        نقاط القوة (Strengths)
                    </h6>
                </div>
                <div class="card-body">
                    <?php $__currentLoopData = $companyPlan->strengths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $strength): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="d-flex align-items-start mb-2">
                        <div class="me-2">
                            <i class="fas fa-check-circle text-success"></i>
                        </div>
                        <div>
                            <p class="mb-0"><?php echo e($strength); ?></p>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        
        <!-- نقاط الضعف -->
        <div class="col-md-6 mb-4">
            <div class="card border-warning h-100">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0">
                        <i class="fas fa-thumbs-down me-2"></i>
                        نقاط الضعف (Weaknesses)
                    </h6>
                </div>
                <div class="card-body">
                    <?php $__currentLoopData = $companyPlan->weaknesses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $weakness): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="d-flex align-items-start mb-2">
                        <div class="me-2">
                            <i class="fas fa-exclamation-circle text-warning"></i>
                        </div>
                        <div>
                            <p class="mb-0"><?php echo e($weakness); ?></p>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- الفرص -->
        <div class="col-md-6 mb-4">
            <div class="card border-info h-100">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-lightbulb me-2"></i>
                        الفرص (Opportunities)
                    </h6>
                </div>
                <div class="card-body">
                    <?php $__currentLoopData = $companyPlan->opportunities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $opportunity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="d-flex align-items-start mb-2">
                        <div class="me-2">
                            <i class="fas fa-star text-info"></i>
                        </div>
                        <div>
                            <p class="mb-0"><?php echo e($opportunity); ?></p>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        
        <!-- التهديدات -->
        <div class="col-md-6 mb-4">
            <div class="card border-danger h-100">
                <div class="card-header bg-danger text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        التهديدات (Threats)
                    </h6>
                </div>
                <div class="card-body">
                    <?php $__currentLoopData = $companyPlan->threats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $threat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="d-flex align-items-start mb-2">
                        <div class="me-2">
                            <i class="fas fa-times-circle text-danger"></i>
                        </div>
                        <div>
                            <p class="mb-0"><?php echo e($threat); ?></p>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- الاستراتيجيات وعناصر العمل -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">
                        <i class="fas fa-cogs me-2 text-primary"></i>
                        الاستراتيجيات
                    </h6>
                </div>
                <div class="card-body">
                    <?php $__currentLoopData = $companyPlan->strategies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $strategy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="d-flex align-items-start mb-3">
                        <div class="me-3">
                            <span class="badge bg-primary rounded-circle"><?php echo e($index + 1); ?></span>
                        </div>
                        <div>
                            <p class="mb-0"><?php echo e($strategy); ?></p>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">
                        <i class="fas fa-tasks me-2 text-primary"></i>
                        عناصر العمل
                    </h6>
                </div>
                <div class="card-body">
                    <?php $__currentLoopData = $companyPlan->action_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $actionItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="d-flex align-items-start mb-3">
                        <div class="me-3">
                            <span class="badge bg-success rounded-circle"><?php echo e($index + 1); ?></span>
                        </div>
                        <div>
                            <p class="mb-0"><?php echo e($actionItem); ?></p>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- تحديث حالة الخطة -->
    <div class="dashboard-card">
        <div class="card-header bg-white border-bottom">
            <h6 class="mb-0">
                <i class="fas fa-cog me-2 text-primary"></i>
                تحديث حالة الخطة
            </h6>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('admin.company-plans.update-status', $companyPlan)); ?>" method="POST" class="d-inline">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="row">
                    <div class="col-md-4">
                        <select name="status" class="form-select" required>
                            <option value="draft" <?php echo e($companyPlan->status === 'draft' ? 'selected' : ''); ?>>مسودة</option>
                            <option value="active" <?php echo e($companyPlan->status === 'active' ? 'selected' : ''); ?>>نشطة</option>
                            <option value="completed" <?php echo e($companyPlan->status === 'completed' ? 'selected' : ''); ?>>مكتملة</option>
                            <option value="cancelled" <?php echo e($companyPlan->status === 'cancelled' ? 'selected' : ''); ?>>ملغية</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            تحديث الحالة
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views/admin/company-plans/show.blade.php ENDPATH**/ ?>