

<?php $__env->startSection('title', 'رسائل التواصل'); ?>
<?php $__env->startSection('dashboard-title', 'لوحة الإدارة'); ?>
<?php $__env->startSection('page-title', 'رسائل التواصل'); ?>
<?php $__env->startSection('page-subtitle', 'إدارة رسائل التواصل من زوار الموقع'); ?>

<?php $__env->startSection('content'); ?>
<div class="row g-4">
    <!-- إحصائيات سريعة -->
    <div class="col-12">
        <div class="row g-3">
            <div class="col-md-2">
                <div class="dashboard-card text-center">
                    <div class="card-body">
                        <h3 class="text-primary"><?php echo e($stats['total']); ?></h3>
                        <p class="mb-0">إجمالي الرسائل</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="dashboard-card text-center">
                    <div class="card-body">
                        <h3 class="text-warning"><?php echo e($stats['new']); ?></h3>
                        <p class="mb-0">رسائل جديدة</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="dashboard-card text-center">
                    <div class="card-body">
                        <h3 class="text-info"><?php echo e($stats['read']); ?></h3>
                        <p class="mb-0">مقروءة</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="dashboard-card text-center">
                    <div class="card-body">
                        <h3 class="text-success"><?php echo e($stats['replied']); ?></h3>
                        <p class="mb-0">تم الرد عليها</p>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="dashboard-card text-center">
                    <div class="card-body">
                        <h3 class="text-secondary"><?php echo e($stats['closed']); ?></h3>
                        <p class="mb-0">مغلقة</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- فلترة وبحث -->
    <div class="col-12">
        <div class="dashboard-card">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">البحث</label>
                        <input type="text" class="form-control" name="search" 
                               value="<?php echo e(request('search')); ?>" placeholder="البحث في الرسائل...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">الحالة</label>
                        <select class="form-select" name="status">
                            <option value="">جميع الحالات</option>
                            <option value="new" <?php echo e(request('status') == 'new' ? 'selected' : ''); ?>>جديدة</option>
                            <option value="read" <?php echo e(request('status') == 'read' ? 'selected' : ''); ?>>مقروءة</option>
                            <option value="replied" <?php echo e(request('status') == 'replied' ? 'selected' : ''); ?>>تم الرد عليها</option>
                            <option value="closed" <?php echo e(request('status') == 'closed' ? 'selected' : ''); ?>>مغلقة</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-1"></i>بحث
                            </button>
                            <a href="<?php echo e(route('admin.contacts.index')); ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>مسح
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- قائمة الرسائل -->
    <div class="col-12">
        <div class="dashboard-card">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0">
                    <i class="fas fa-envelope me-2 text-primary"></i>
                    رسائل التواصل
                </h5>
            </div>
            <div class="card-body p-0">
                <?php if($contacts->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>المرسل</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>الموضوع</th>
                                    <th>الحالة</th>
                                    <th>التاريخ</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="<?php echo e($contact->status === 'new' ? 'table-warning' : ''); ?>">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                                    <?php echo e(substr($contact->name, 0, 1)); ?>

                                                </div>
                                                <div>
                                                    <h6 class="mb-0"><?php echo e($contact->name); ?></h6>
                                                    <?php if($contact->phone): ?>
                                                        <small class="text-muted"><?php echo e($contact->phone); ?></small>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?php echo e($contact->email); ?></td>
                                        <td>
                                            <span class="badge bg-light text-dark"><?php echo e($contact->subject); ?></span>
                                        </td>
                                        <td>
                                            <?php switch($contact->status):
                                                case ('new'): ?>
                                                    <span class="badge bg-warning">جديدة</span>
                                                    <?php break; ?>
                                                <?php case ('read'): ?>
                                                    <span class="badge bg-info">مقروءة</span>
                                                    <?php break; ?>
                                                <?php case ('replied'): ?>
                                                    <span class="badge bg-success">تم الرد عليها</span>
                                                    <?php break; ?>
                                                <?php case ('closed'): ?>
                                                    <span class="badge bg-secondary">مغلقة</span>
                                                    <?php break; ?>
                                            <?php endswitch; ?>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <?php echo e($contact->created_at->format('Y-m-d H:i')); ?>

                                            </small>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="<?php echo e(route('admin.contacts.show', $contact)); ?>" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <?php if($contact->status === 'new'): ?>
                                                    <form method="POST" action="<?php echo e(route('admin.contacts.mark-read', $contact)); ?>" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PATCH'); ?>
                                                        <button type="submit" class="btn btn-sm btn-outline-info" title="تمييز كمقروءة">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                                <?php if($contact->status !== 'replied'): ?>
                                                    <form method="POST" action="<?php echo e(route('admin.contacts.mark-replied', $contact)); ?>" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PATCH'); ?>
                                                        <button type="submit" class="btn btn-sm btn-outline-success" title="تمييز كرد عليها">
                                                            <i class="fas fa-reply"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                                <?php if($contact->status !== 'closed'): ?>
                                                    <form method="POST" action="<?php echo e(route('admin.contacts.mark-closed', $contact)); ?>" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PATCH'); ?>
                                                        <button type="submit" class="btn btn-sm btn-outline-secondary" title="إغلاق">
                                                            <i class="fas fa-lock"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                                <form method="POST" action="<?php echo e(route('admin.contacts.destroy', $contact)); ?>" 
                                                      class="d-inline" 
                                                      onsubmit="return confirm('هل أنت متأكد من حذف هذه الرسالة؟')">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="card-footer bg-white border-top">
                        <?php echo e($contacts->links()); ?>

                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">لا توجد رسائل</h5>
                        <p class="text-muted">لم يتم استلام أي رسائل بعد</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views/admin/contacts/index.blade.php ENDPATH**/ ?>