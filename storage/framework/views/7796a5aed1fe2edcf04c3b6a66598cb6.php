

<?php $__env->startSection('title', 'عرض جهة الاتصال'); ?>
<?php $__env->startSection('dashboard-title', 'لوحة الإدارة'); ?>
<?php $__env->startSection('page-title', 'عرض جهة الاتصال'); ?>
<?php $__env->startSection('page-subtitle', 'تفاصيل جهة الاتصال'); ?>

<?php $__env->startSection('content'); ?>
<div class="row g-4">
    <div class="col-lg-8">
        <!-- تفاصيل الجهة -->
        <div class="dashboard-card">
            <div class="card-header bg-white border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-address-book me-2 text-primary"></i>
                        تفاصيل الجهة
                    </h5>
                    <div class="d-flex gap-2">
                        <span class="badge bg-<?php echo e($contact->priority_badge); ?> fs-6">
                            <?php echo e($contact->priority_text); ?>

                        </span>
                        <?php switch($contact->status):
                            case ('new'): ?>
                                <span class="badge bg-warning fs-6">جديدة</span>
                                <?php break; ?>
                            <?php case ('read'): ?>
                                <span class="badge bg-info fs-6">مقروءة</span>
                                <?php break; ?>
                            <?php case ('replied'): ?>
                                <span class="badge bg-success fs-6">تم الرد عليها</span>
                                <?php break; ?>
                            <?php case ('closed'): ?>
                                <span class="badge bg-secondary fs-6">مغلقة</span>
                                <?php break; ?>
                        <?php endswitch; ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- معلومات المرسل -->
                <!-- معلومات أساسية -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="contact-info-item">
                            <label class="form-label fw-bold">الاسم:</label>
                            <p class="mb-0"><?php echo e($contact->name); ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="contact-info-item">
                            <label class="form-label fw-bold">البريد الإلكتروني:</label>
                            <p class="mb-0">
                                <a href="mailto:<?php echo e($contact->email); ?>" class="text-primary">
                                    <?php echo e($contact->email); ?>

                                </a>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <?php if($contact->phone): ?>
                    <div class="col-md-6">
                        <div class="contact-info-item">
                            <label class="form-label fw-bold">رقم الهاتف:</label>
                            <p class="mb-0">
                                <a href="tel:<?php echo e($contact->phone); ?>" class="text-primary">
                                    <?php echo e($contact->phone); ?>

                                </a>
                            </p>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if($contact->company): ?>
                    <div class="col-md-6">
                        <div class="contact-info-item">
                            <label class="form-label fw-bold">الشركة:</label>
                            <p class="mb-0"><?php echo e($contact->company); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- معلومات الجهة -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="contact-info-item">
                            <label class="form-label fw-bold">نوع الجهة:</label>
                            <p class="mb-0">
                                <span class="badge bg-<?php echo e($contact->contact_type === 'inquiry' ? 'info' : 'warning'); ?>">
                                    <?php echo e($contact->contact_type === 'inquiry' ? 'استفسار' : 'مخصص'); ?>

                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="contact-info-item">
                            <label class="form-label fw-bold">المصدر:</label>
                            <p class="mb-0"><?php echo e($contact->source_text); ?></p>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="contact-info-item">
                            <label class="form-label fw-bold">التعيين:</label>
                            <p class="mb-0">
                                <span class="badge bg-<?php echo e($contact->assigned_to === 'marketing' ? 'primary' : ($contact->assigned_to === 'sales' ? 'success' : 'info')); ?>">
                                    <?php echo e($contact->assigned_to_text); ?>

                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="contact-info-item">
                            <label class="form-label fw-bold">الموضوع:</label>
                            <p class="mb-0">
                                <span class="badge bg-light text-dark fs-6"><?php echo e($contact->subject); ?></span>
                            </p>
                        </div>
                    </div>
                </div>

                <?php if($contact->tags && count($contact->tags) > 0): ?>
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="contact-info-item">
                            <label class="form-label fw-bold">العلامات:</label>
                            <div class="d-flex flex-wrap gap-1">
                                <?php $__currentLoopData = $contact->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="badge bg-secondary"><?php echo e($tag); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if($contact->follow_up_date): ?>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="contact-info-item">
                            <label class="form-label fw-bold">موعد المتابعة:</label>
                            <p class="mb-0 text-warning">
                                <i class="fas fa-clock me-1"></i>
                                <?php echo e($contact->follow_up_date->format('Y-m-d H:i')); ?>

                            </p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="contact-info-item">
                            <label class="form-label fw-bold">تاريخ الإرسال:</label>
                            <p class="mb-0"><?php echo e($contact->created_at->format('Y-m-d H:i')); ?></p>
                        </div>
                    </div>
                    <?php if($contact->read_at): ?>
                    <div class="col-md-6">
                        <div class="contact-info-item">
                            <label class="form-label fw-bold">تاريخ القراءة:</label>
                            <p class="mb-0"><?php echo e($contact->read_at->format('Y-m-d H:i')); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- نص الرسالة -->
                <div class="message-content">
                    <label class="form-label fw-bold">نص الرسالة:</label>
                    <div class="bg-light p-3 rounded">
                        <p class="mb-0" style="white-space: pre-wrap;"><?php echo e($contact->message); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- إدارة الجهة -->
        <div class="dashboard-card">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0">
                    <i class="fas fa-cogs me-2 text-primary"></i>
                    إدارة الجهة
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('admin.contacts.update', $contact)); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    
                    <div class="mb-3">
                        <label class="form-label">تغيير الحالة</label>
                        <select class="form-select" name="status">
                            <option value="new" <?php echo e($contact->status === 'new' ? 'selected' : ''); ?>>جديدة</option>
                            <option value="read" <?php echo e($contact->status === 'read' ? 'selected' : ''); ?>>مقروءة</option>
                            <option value="replied" <?php echo e($contact->status === 'replied' ? 'selected' : ''); ?>>تم الرد عليها</option>
                            <option value="closed" <?php echo e($contact->status === 'closed' ? 'selected' : ''); ?>>مغلقة</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">نوع الجهة</label>
                        <select class="form-select" name="contact_type">
                            <option value="inquiry" <?php echo e($contact->contact_type === 'inquiry' ? 'selected' : ''); ?>>استفسار</option>
                            <option value="custom" <?php echo e($contact->contact_type === 'custom' ? 'selected' : ''); ?>>مخصص</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">التعيين</label>
                        <select class="form-select" name="assigned_to">
                            <option value="marketing" <?php echo e($contact->assigned_to === 'marketing' ? 'selected' : ''); ?>>فريق التسويق</option>
                            <option value="sales" <?php echo e($contact->assigned_to === 'sales' ? 'selected' : ''); ?>>فريق المبيعات</option>
                            <option value="both" <?php echo e($contact->assigned_to === 'both' ? 'selected' : ''); ?>>كلا الفريقين</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">الأولوية</label>
                        <select class="form-select" name="priority">
                            <option value="low" <?php echo e($contact->priority === 'low' ? 'selected' : ''); ?>>منخفض</option>
                            <option value="medium" <?php echo e($contact->priority === 'medium' ? 'selected' : ''); ?>>متوسط</option>
                            <option value="high" <?php echo e($contact->priority === 'high' ? 'selected' : ''); ?>>عالي</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">موعد المتابعة</label>
                        <input type="datetime-local" class="form-control" name="follow_up_date" 
                               value="<?php echo e($contact->follow_up_date ? $contact->follow_up_date->format('Y-m-d\TH:i') : ''); ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ملاحظات الإدارة</label>
                        <textarea class="form-control" name="admin_notes" rows="4" 
                                  placeholder="أضف ملاحظات أو تعليقات..."><?php echo e($contact->admin_notes); ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save me-2"></i>
                        حفظ التغييرات
                    </button>
                </form>

                <hr>

                <!-- إجراءات سريعة -->
                <div class="d-grid gap-2">
                    <?php if($contact->status === 'new'): ?>
                        <form method="POST" action="<?php echo e(route('admin.contacts.mark-read', $contact)); ?>">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button type="submit" class="btn btn-info w-100">
                                <i class="fas fa-check me-2"></i>
                                تمييز كمقروءة
                            </button>
                        </form>
                    <?php endif; ?>

                    <?php if($contact->status !== 'replied'): ?>
                        <form method="POST" action="<?php echo e(route('admin.contacts.mark-replied', $contact)); ?>">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-reply me-2"></i>
                                تمييز كرد عليها
                            </button>
                        </form>
                    <?php endif; ?>

                    <?php if($contact->status !== 'closed'): ?>
                        <form method="POST" action="<?php echo e(route('admin.contacts.mark-closed', $contact)); ?>">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button type="submit" class="btn btn-secondary w-100">
                                <i class="fas fa-lock me-2"></i>
                                إغلاق الجهة
                            </button>
                        </form>
                    <?php endif; ?>

                    <a href="<?php echo e(route('admin.contacts.edit', $contact)); ?>" 
                       class="btn btn-outline-warning w-100">
                        <i class="fas fa-edit me-2"></i>
                        تعديل الجهة
                    </a>

                    <a href="mailto:<?php echo e($contact->email); ?>?subject=رد على: <?php echo e($contact->subject); ?>" 
                       class="btn btn-outline-primary w-100">
                        <i class="fas fa-envelope me-2"></i>
                        الرد بالبريد الإلكتروني
                    </a>

                    <?php if($contact->phone): ?>
                    <a href="tel:<?php echo e($contact->phone); ?>" 
                       class="btn btn-outline-success w-100">
                        <i class="fas fa-phone me-2"></i>
                        الاتصال بالهاتف
                    </a>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('admin.contacts.destroy', $contact)); ?>" 
                          onsubmit="return confirm('هل أنت متأكد من حذف هذه الجهة؟')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="fas fa-trash me-2"></i>
                            حذف الجهة
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- معلومات إضافية -->
        <div class="dashboard-card mt-4">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2 text-primary"></i>
                    معلومات إضافية
                </h5>
            </div>
            <div class="card-body">
                <div class="info-item mb-3">
                    <label class="form-label fw-bold">معرف الجهة:</label>
                    <p class="mb-0 text-muted">#<?php echo e($contact->id); ?></p>
                </div>

                <div class="info-item mb-3">
                    <label class="form-label fw-bold">عدد مرات التواصل:</label>
                    <p class="mb-0 text-muted"><?php echo e($contact->contact_count ?? 0); ?> مرة</p>
                </div>

                <?php if($contact->last_contact_date): ?>
                <div class="info-item mb-3">
                    <label class="form-label fw-bold">آخر تواصل:</label>
                    <p class="mb-0 text-muted"><?php echo e($contact->last_contact_date->format('Y-m-d H:i')); ?></p>
                </div>
                <?php endif; ?>
                
                <?php if($contact->replied_at): ?>
                <div class="info-item mb-3">
                    <label class="form-label fw-bold">تاريخ الرد:</label>
                    <p class="mb-0 text-muted"><?php echo e($contact->replied_at->format('Y-m-d H:i')); ?></p>
                </div>
                <?php endif; ?>

                <?php if($contact->creator): ?>
                <div class="info-item mb-3">
                    <label class="form-label fw-bold">أنشأ بواسطة:</label>
                    <p class="mb-0 text-muted"><?php echo e($contact->creator->name); ?></p>
                </div>
                <?php endif; ?>

                <?php if($contact->updater): ?>
                <div class="info-item mb-3">
                    <label class="form-label fw-bold">آخر تحديث بواسطة:</label>
                    <p class="mb-0 text-muted"><?php echo e($contact->updater->name); ?></p>
                </div>
                <?php endif; ?>

                <div class="info-item">
                    <label class="form-label fw-bold">آخر تحديث:</label>
                    <p class="mb-0 text-muted"><?php echo e($contact->updated_at->format('Y-m-d H:i')); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="d-flex justify-content-between">
            <a href="<?php echo e(route('admin.contacts.index')); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-right me-2"></i>
                العودة للقائمة
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\admin\contacts\show.blade.php ENDPATH**/ ?>