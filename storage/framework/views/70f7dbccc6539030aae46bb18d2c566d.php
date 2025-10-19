

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
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon primary">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0"><?php echo e($stats['total']); ?></h3>
                    <p class="mb-0 text-muted">إجمالي الجهات</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0"><?php echo e($stats['new']); ?></h3>
                    <p class="mb-0 text-muted">جديدة</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon info">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0"><?php echo e($stats['read']); ?></h3>
                    <p class="mb-0 text-muted">مقروءة</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon success">
                    <i class="fas fa-reply"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0"><?php echo e($stats['replied']); ?></h3>
                    <p class="mb-0 text-muted">تم الرد عليها</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon danger">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0"><?php echo e($stats['high_priority']); ?></h3>
                    <p class="mb-0 text-muted">أولوية عالية</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0"><?php echo e($stats['follow_up_today']); ?></h3>
                    <p class="mb-0 text-muted">متابعة اليوم</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- فلترة جهات الاتصال -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('sales.contacts')); ?>" class="row g-3">
            <div class="col-md-3">
                <label for="status" class="form-label">الحالة</label>
                <select name="status" id="status" class="form-select">
                    <option value="">جميع الحالات</option>
                    <option value="new" <?php echo e(request('status') == 'new' ? 'selected' : ''); ?>>جديدة</option>
                    <option value="read" <?php echo e(request('status') == 'read' ? 'selected' : ''); ?>>مقروءة</option>
                    <option value="replied" <?php echo e(request('status') == 'replied' ? 'selected' : ''); ?>>تم الرد عليها</option>
                    <option value="closed" <?php echo e(request('status') == 'closed' ? 'selected' : ''); ?>>مغلقة</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="contact_type" class="form-label">نوع الجهة</label>
                <select name="contact_type" id="contact_type" class="form-select">
                    <option value="">جميع الأنواع</option>
                    <option value="inquiry" <?php echo e(request('contact_type') == 'inquiry' ? 'selected' : ''); ?>>استفسار</option>
                    <option value="custom" <?php echo e(request('contact_type') == 'custom' ? 'selected' : ''); ?>>مخصص</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="priority" class="form-label">الأولوية</label>
                <select name="priority" id="priority" class="form-select">
                    <option value="">جميع الأولويات</option>
                    <option value="high" <?php echo e(request('priority') == 'high' ? 'selected' : ''); ?>>عالية</option>
                    <option value="medium" <?php echo e(request('priority') == 'medium' ? 'selected' : ''); ?>>متوسطة</option>
                    <option value="low" <?php echo e(request('priority') == 'low' ? 'selected' : ''); ?>>منخفضة</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="source" class="form-label">المصدر</label>
                <select name="source" id="source" class="form-select">
                    <option value="">جميع المصادر</option>
                    <option value="website" <?php echo e(request('source') == 'website' ? 'selected' : ''); ?>>الموقع</option>
                    <option value="phone" <?php echo e(request('source') == 'phone' ? 'selected' : ''); ?>>هاتف</option>
                    <option value="email" <?php echo e(request('source') == 'email' ? 'selected' : ''); ?>>بريد إلكتروني</option>
                    <option value="referral" <?php echo e(request('source') == 'referral' ? 'selected' : ''); ?>>إحالة</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="search" class="form-label">البحث</label>
                <input type="text" name="search" id="search" class="form-control" 
                       placeholder="البحث بالاسم، البريد الإلكتروني، أو الموضوع..." 
                       value="<?php echo e(request('search')); ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">&nbsp;</label>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i>فلترة
                    </button>
                    <a href="<?php echo e(route('sales.contacts')); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i>مسح
                    </a>
                </div>
            </div>
        </form>
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
                            <th>الجهة</th>
                            <th>المعلومات</th>
                            <th>النوع</th>
                            <th>الأولوية</th>
                            <th>الحالة</th>
                            <th>التاريخ</th>
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
                                            <?php if($contact->company): ?>
                                                <small class="text-muted"><?php echo e($contact->company); ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <a href="mailto:<?php echo e($contact->email); ?>" class="text-decoration-none">
                                            <?php echo e($contact->email); ?>

                                        </a>
                                        <?php if($contact->phone): ?>
                                            <br><small class="text-muted">
                                                <i class="fas fa-phone me-1"></i><?php echo e($contact->phone); ?>

                                            </small>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <?php if($contact->contact_type === 'inquiry'): ?>
                                        <span class="badge bg-info">استفسار</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">مخصص</span>
                                    <?php endif; ?>
                                    <?php if($contact->source): ?>
                                        <br><small class="text-muted"><?php echo e($contact->source_text); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php echo $contact->priority_badge; ?>

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
                                    <div>
                                        <small class="text-muted">
                                            <?php echo e(\Carbon\Carbon::parse($contact->created_at)->format('Y-m-d')); ?>

                                        </small>
                                        <br>
                                        <small class="text-muted">
                                            <?php echo e(\Carbon\Carbon::parse($contact->created_at)->format('H:i')); ?>

                                        </small>
                                        <?php if($contact->follow_up_date): ?>
                                            <br><small class="text-warning">
                                                <i class="fas fa-clock me-1"></i>متابعة: <?php echo e($contact->follow_up_date->format('m/d')); ?>

                                            </small>
                                        <?php endif; ?>
                                    </div>
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

<?php echo $__env->make('layouts.sales-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\sales\contacts\index.blade.php ENDPATH**/ ?>