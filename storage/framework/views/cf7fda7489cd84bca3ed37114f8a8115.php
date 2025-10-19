<?php $__env->startSection('title', 'إدارة خطط الشركة'); ?>
<?php $__env->startSection('dashboard-title', 'لوحة الإدارة'); ?>
<?php $__env->startSection('page-title', 'إدارة خطط الشركة'); ?>
<?php $__env->startSection('page-subtitle', 'عرض وإدارة جميع خطط الشركة الاستراتيجية'); ?>
<?php $__env->startSection('profile-route', '#'); ?>
<?php $__env->startSection('settings-route', '#'); ?>

<?php $__env->startSection('sidebar-menu'); ?>
    <?php echo $__env->make('partials.admin-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-actions'); ?>
    <a href="<?php echo e(route('admin.company-plans.create')); ?>" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        إنشاء خطة جديدة
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <!-- إحصائيات سريعة -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4><?php echo e($stats['total']); ?></h4>
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
                            <h4><?php echo e($stats['active']); ?></h4>
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
                            <h4><?php echo e($stats['completed']); ?></h4>
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
                            <h4><?php echo e($stats['draft']); ?></h4>
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
            <?php if($plans->count() > 0): ?>
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
                            <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="fas fa-chart-line text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0"><?php echo e($plan->title); ?></h6>
                                            <small class="text-muted"><?php echo e(Str::limit($plan->description, 50)); ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info"><?php echo e($plan->type_label); ?></span>
                                </td>
                                <td>
                                    <span class="badge bg-<?php echo e($plan->status_color); ?>"><?php echo e($plan->status_label); ?></span>
                                    <?php if($plan->is_overdue): ?>
                                        <span class="badge bg-danger ms-1">متأخرة</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar bg-<?php echo e($plan->progress_percentage >= 100 ? 'success' : ($plan->progress_percentage >= 75 ? 'info' : ($plan->progress_percentage >= 50 ? 'warning' : 'danger'))); ?>" 
                                             role="progressbar" 
                                             style="width: <?php echo e($plan->progress_percentage); ?>%">
                                            <?php echo e($plan->progress_percentage); ?>%
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <small class="text-muted">من: <?php echo e($plan->start_date->format('Y-m-d')); ?></small><br>
                                        <small class="text-muted">إلى: <?php echo e($plan->end_date->format('Y-m-d')); ?></small>
                                        <?php if($plan->days_remaining > 0): ?>
                                            <br><small class="text-info"><?php echo e($plan->days_remaining); ?> يوم متبقي</small>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <?php if($plan->assignee): ?>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>
                                            <div>
                                                <small><?php echo e($plan->assignee->name); ?></small>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted">غير محدد</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($plan->budget): ?>
                                        <div>
                                            <strong><?php echo e(number_format($plan->budget, 2)); ?> ر.س</strong>
                                            <?php if($plan->actual_cost): ?>
                                                <br><small class="text-muted">الفعلي: <?php echo e(number_format($plan->actual_cost, 2)); ?> ر.س</small>
                                                <br><small class="text-<?php echo e($plan->cost_percentage > 100 ? 'danger' : 'success'); ?>">
                                                    (<?php echo e($plan->cost_percentage); ?>%)
                                                </small>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted">غير محدد</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?php echo e(route('admin.company-plans.show', $plan)); ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?php echo e(route('admin.company-plans.edit', $plan)); ?>" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-info dropdown-toggle" data-bs-toggle="dropdown">
                                                <i class="fas fa-cog"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <form action="<?php echo e(route('admin.company-plans.update-status', $plan)); ?>" method="POST" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PUT'); ?>
                                                        <input type="hidden" name="status" value="active">
                                                        <button type="submit" class="dropdown-item">تفعيل</button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form action="<?php echo e(route('admin.company-plans.update-status', $plan)); ?>" method="POST" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PUT'); ?>
                                                        <input type="hidden" name="status" value="completed">
                                                        <button type="submit" class="dropdown-item">إكمال</button>
                                                    </form>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="<?php echo e(route('admin.company-plans.destroy', $plan)); ?>" method="POST" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
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
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    <?php echo e($plans->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-chart-line fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">لا توجد خطط حتى الآن</h4>
                    <p class="text-muted mb-4">ابدأ بإنشاء خطة استراتيجية جديدة للشركة</p>
                    <a href="<?php echo e(route('admin.company-plans.create')); ?>" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>
                        إنشاء خطة جديدة
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\admin\company-plans\index.blade.php ENDPATH**/ ?>