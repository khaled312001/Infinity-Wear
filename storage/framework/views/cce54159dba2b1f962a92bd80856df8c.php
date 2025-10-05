

<?php $__env->startSection('title', 'جهات الاتصال - فريق المبيعات'); ?>
<?php $__env->startSection('dashboard-title', 'جهات الاتصال'); ?>
<?php $__env->startSection('page-title', 'قائمة جهات الاتصال'); ?>
<?php $__env->startSection('page-subtitle', 'إدارة وتتبع جميع جهات الاتصال'); ?>

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
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0"><?php echo e($contacts->total()); ?></h3>
                    <p class="mb-0 text-muted">إجمالي جهات الاتصال</p>
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
                    <h3 class="mb-0"><?php echo e($contacts->where('status', 'new')->count()); ?></h3>
                    <p class="mb-0 text-muted">جديدة</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon info">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0"><?php echo e($contacts->where('status', 'read')->count()); ?></h3>
                    <p class="mb-0 text-muted">مقروءة</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon success">
                    <i class="fas fa-reply"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0"><?php echo e($contacts->where('status', 'replied')->count()); ?></h3>
                    <p class="mb-0 text-muted">تم الرد عليها</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- فلترة جهات الاتصال -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h6 class="mb-0">فلترة جهات الاتصال</h6>
            </div>
            <div class="col-md-6">
                <div class="d-flex gap-2 justify-content-end">
                    <button class="btn btn-outline-primary btn-sm" onclick="filterContacts('all')">
                        جميع جهات الاتصال
                    </button>
                    <button class="btn btn-outline-warning btn-sm" onclick="filterContacts('new')">
                        جديدة
                    </button>
                    <button class="btn btn-outline-info btn-sm" onclick="filterContacts('read')">
                        مقروءة
                    </button>
                    <button class="btn btn-outline-success btn-sm" onclick="filterContacts('replied')">
                        تم الرد عليها
                    </button>
                    <button class="btn btn-outline-secondary btn-sm" onclick="filterContacts('closed')">
                        مغلقة
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- قائمة جهات الاتصال -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-address-book me-2"></i>
            جهات الاتصال
        </h5>
    </div>
    <div class="card-body">
        <?php if($contacts->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>الاسم</th>
                            <th>البريد الإلكتروني</th>
                            <th>الهاتف</th>
                            <th>الشركة</th>
                            <th>الموضوع</th>
                            <th>الحالة</th>
                            <th>تاريخ الإرسال</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr data-status="<?php echo e($contact->status); ?>">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="fas fa-user-circle text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0"><?php echo e($contact->name); ?></h6>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo e($contact->email); ?></td>
                                <td><?php echo e($contact->phone ?? 'غير محدد'); ?></td>
                                <td><?php echo e($contact->company ?? 'غير محدد'); ?></td>
                                <td>
                                    <p class="mb-0 text-truncate" style="max-width: 200px;" title="<?php echo e($contact->subject); ?>">
                                        <?php echo e($contact->subject); ?>

                                    </p>
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
                                        <?php echo e(\Carbon\Carbon::parse($contact->created_at)->format('Y-m-d H:i')); ?>

                                    </small>
                                </td>
                                <td>
                                    <a href="<?php echo e(route('sales.contacts.show', $contact->id)); ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                <?php echo e($contacts->links()); ?>

            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-envelope fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">لا توجد جهات اتصال حالياً</h5>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
function filterContacts(status) {
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        if (status === 'all' || row.dataset.status === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
    
    // Update button states
    document.querySelectorAll('.btn-outline-primary, .btn-outline-warning, .btn-outline-info, .btn-outline-success, .btn-outline-secondary').forEach(btn => {
        btn.classList.remove('active');
    });
    
    event.target.classList.add('active');
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.sales-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views/sales/contacts/index.blade.php ENDPATH**/ ?>