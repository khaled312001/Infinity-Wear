

<?php $__env->startSection('title', 'تفاصيل جهة الاتصال - فريق المبيعات'); ?>
<?php $__env->startSection('dashboard-title', 'تفاصيل جهة الاتصال'); ?>
<?php $__env->startSection('page-title', 'تفاصيل جهة الاتصال'); ?>
<?php $__env->startSection('page-subtitle', 'عرض وتعديل تفاصيل جهة الاتصال'); ?>

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

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-envelope me-2"></i>
                    تفاصيل جهة الاتصال
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>معلومات جهة الاتصال</h6>
                        <ul class="list-unstyled">
                            <li><strong>الاسم:</strong> <?php echo e($contact->name); ?></li>
                            <li><strong>البريد الإلكتروني:</strong> <?php echo e($contact->email); ?></li>
                            <li><strong>الهاتف:</strong> <?php echo e($contact->phone ?? 'غير محدد'); ?></li>
                            <li><strong>الشركة:</strong> <?php echo e($contact->company ?? 'غير محدد'); ?></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>معلومات إضافية</h6>
                        <ul class="list-unstyled">
                            <li><strong>الموضوع:</strong> <?php echo e($contact->subject); ?></li>
                            <li><strong>الحالة:</strong> 
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
                            </li>
                            <li><strong>تاريخ الإرسال:</strong> <?php echo e(\Carbon\Carbon::parse($contact->created_at)->format('Y-m-d H:i')); ?></li>
                            <?php if($contact->updated_at): ?>
                                <li><strong>آخر تحديث:</strong> <?php echo e(\Carbon\Carbon::parse($contact->updated_at)->format('Y-m-d H:i')); ?></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                
                <div class="mt-4">
                    <h6>الرسالة</h6>
                    <div class="alert alert-info">
                        <?php echo e($contact->message); ?>

                    </div>
                </div>
                
                <?php if($contact->admin_notes): ?>
                    <div class="mt-3">
                        <h6>ملاحظات</h6>
                        <div class="alert alert-warning">
                            <?php echo e($contact->admin_notes); ?>

                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-cogs me-2"></i>
                    إدارة جهة الاتصال
                </h5>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('sales.contacts.update', $contact->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="mb-3">
                        <label for="name" class="form-label">الاسم</label>
                        <input type="text" name="name" id="name" class="form-control" value="<?php echo e($contact->name); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">البريد الإلكتروني</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?php echo e($contact->email); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">الهاتف</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="<?php echo e($contact->phone); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="company" class="form-label">الشركة</label>
                        <input type="text" name="company" id="company" class="form-control" value="<?php echo e($contact->company); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">الموضوع</label>
                        <input type="text" name="subject" id="subject" class="form-control" value="<?php echo e($contact->subject); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">الرسالة</label>
                        <textarea name="message" id="message" class="form-control" rows="4" required><?php echo e($contact->message); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">الحالة</label>
                        <select name="status" id="status" class="form-select">
                            <option value="new" <?php echo e($contact->status === 'new' ? 'selected' : ''); ?>>جديدة</option>
                            <option value="read" <?php echo e($contact->status === 'read' ? 'selected' : ''); ?>>مقروءة</option>
                            <option value="replied" <?php echo e($contact->status === 'replied' ? 'selected' : ''); ?>>تم الرد عليها</option>
                            <option value="closed" <?php echo e($contact->status === 'closed' ? 'selected' : ''); ?>>مغلقة</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="admin_notes" class="form-label">ملاحظات</label>
                        <textarea name="admin_notes" id="admin_notes" class="form-control" rows="3"><?php echo e($contact->admin_notes); ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save me-2"></i>
                        حفظ التغييرات
                    </button>
                </form>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-reply me-2"></i>
                    الرد السريع
                </h5>
            </div>
            <div class="card-body">
                <a href="mailto:<?php echo e($contact->email); ?>?subject=رد على: <?php echo e($contact->subject); ?>" class="btn btn-success w-100 mb-2">
                    <i class="fas fa-envelope me-2"></i>
                    إرسال بريد إلكتروني
                </a>
                <?php if($contact->phone): ?>
                    <a href="tel:<?php echo e($contact->phone); ?>" class="btn btn-info w-100">
                        <i class="fas fa-phone me-2"></i>
                        الاتصال بالهاتف
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.sales-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\sales\contacts\show.blade.php ENDPATH**/ ?>