<?php $__env->startSection('title', 'تفاصيل المستخدم'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Header Section -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">تفاصيل المستخدم</h1>
                    <p class="text-muted"><?php echo e($user->name); ?></p>
                </div>
                <div>
                    <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-right"></i> العودة للقائمة
                    </a>
                    <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="btn btn-primary">
                        <i class="fas fa-edit"></i> تعديل
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <!-- User Profile Card -->
                    <div class="card">
                        <div class="card-body text-center">
                            <?php if($user->avatar): ?>
                                <img src="<?php echo e(asset('storage/' . $user->avatar)); ?>" 
                                     alt="<?php echo e($user->name); ?>" 
                                     class="rounded-circle mb-3" 
                                     width="120" height="120">
                            <?php else: ?>
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                                     style="width: 120px; height: 120px; font-size: 2rem;">
                                    <?php echo e(substr($user->name, 0, 1)); ?>

                                </div>
                            <?php endif; ?>
                            
                            <h4><?php echo e($user->name); ?></h4>
                            <p class="text-muted"><?php echo e($user->getUserTypeLabelAttribute()); ?></p>
                            
                            <div class="d-flex justify-content-center mb-3">
                                <?php if($user->is_active): ?>
                                    <span class="badge bg-success fs-6">نشط</span>
                                <?php else: ?>
                                    <span class="badge bg-danger fs-6">غير نشط</span>
                                <?php endif; ?>
                            </div>

                            <?php if($user->bio): ?>
                                <p class="text-muted"><?php echo e($user->bio); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h6 class="card-title mb-0">معلومات التواصل</h6>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item d-flex align-items-center">
                                    <i class="fas fa-envelope text-primary me-2"></i>
                                    <div>
                                        <small class="text-muted">البريد الإلكتروني</small>
                                        <div><?php echo e($user->email); ?></div>
                                    </div>
                                </div>
                                
                                <?php if($user->phone): ?>
                                    <div class="list-group-item d-flex align-items-center">
                                        <i class="fas fa-phone text-success me-2"></i>
                                        <div>
                                            <small class="text-muted">رقم الهاتف</small>
                                            <div><?php echo e($user->phone); ?></div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if($user->city): ?>
                                    <div class="list-group-item d-flex align-items-center">
                                        <i class="fas fa-map-marker-alt text-warning me-2"></i>
                                        <div>
                                            <small class="text-muted">المدينة</small>
                                            <div><?php echo e($user->city); ?></div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if($user->address): ?>
                                    <div class="list-group-item d-flex align-items-center">
                                        <i class="fas fa-home text-info me-2"></i>
                                        <div>
                                            <small class="text-muted">العنوان</small>
                                            <div><?php echo e($user->address); ?></div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Account Information -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h6 class="card-title mb-0">معلومات الحساب</h6>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item d-flex justify-content-between">
                                    <span>تاريخ الإنشاء:</span>
                                    <span><?php echo e($user->created_at->format('Y-m-d H:i')); ?></span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between">
                                    <span>آخر تحديث:</span>
                                    <span><?php echo e($user->updated_at->format('Y-m-d H:i')); ?></span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between">
                                    <span>تأكيد البريد:</span>
                                    <span>
                                        <?php if($user->email_verified_at): ?>
                                            <span class="badge bg-success">مؤكد</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning">غير مؤكد</span>
                                        <?php endif; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <!-- User Type Specific Information -->
                    <?php if($user->user_type === 'importer' && $user->importer): ?>
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0">بيانات المستورد</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>اسم الشركة:</strong>
                                        <p><?php echo e($user->importer->company_name ?: 'غير محدد'); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>نوع الشركة:</strong>
                                        <p>
                                            <?php switch($user->importer->company_type):
                                                case ('individual'): ?>
                                                    فرد
                                                    <?php break; ?>
                                                <?php case ('company'): ?>
                                                    شركة
                                                    <?php break; ?>
                                                <?php case ('institution'): ?>
                                                    مؤسسة
                                                    <?php break; ?>
                                                <?php default: ?>
                                                    غير محدد
                                            <?php endswitch; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>رقم السجل التجاري:</strong>
                                        <p><?php echo e($user->importer->business_license ?: 'غير محدد'); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>حالة التحقق:</strong>
                                        <p>
                                            <?php if($user->importer->is_verified): ?>
                                                <span class="badge bg-success">محقق</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning">غير محقق</span>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($user->user_type === 'marketing' && $user->marketingTeam): ?>
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0">بيانات فريق التسويق</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>القسم:</strong>
                                        <p><?php echo e($user->marketingTeam->department ?: 'غير محدد'); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>المنصب:</strong>
                                        <p><?php echo e($user->marketingTeam->position ?: 'غير محدد'); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>تاريخ التوظيف:</strong>
                                        <p><?php echo e($user->marketingTeam->hire_date ? $user->marketingTeam->hire_date->format('Y-m-d') : 'غير محدد'); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>الحالة:</strong>
                                        <p>
                                            <?php if($user->marketingTeam->is_active): ?>
                                                <span class="badge bg-success">نشط</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">غير نشط</span>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($user->user_type === 'sales' && $user->salesTeam): ?>
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0">بيانات فريق المبيعات</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>القسم:</strong>
                                        <p><?php echo e($user->salesTeam->department ?: 'غير محدد'); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>المنصب:</strong>
                                        <p><?php echo e($user->salesTeam->position ?: 'غير محدد'); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>تاريخ التوظيف:</strong>
                                        <p><?php echo e($user->salesTeam->hire_date ? $user->salesTeam->hire_date->format('Y-m-d') : 'غير محدد'); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>الحالة:</strong>
                                        <p>
                                            <?php if($user->salesTeam->is_active): ?>
                                                <span class="badge bg-success">نشط</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">غير نشط</span>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- User Actions -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h6 class="card-title mb-0">الإجراءات</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="btn btn-primary">
                                    <i class="fas fa-edit"></i> تعديل المستخدم
                                </a>
                                
                                <form method="POST" action="<?php echo e(route('admin.users.toggle-status', $user)); ?>" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" 
                                            class="btn btn-<?php echo e($user->is_active ? 'warning' : 'success'); ?>"
                                            onclick="return confirm('هل أنت متأكد من تغيير حالة المستخدم؟')">
                                        <i class="fas fa-<?php echo e($user->is_active ? 'ban' : 'check'); ?>"></i>
                                        <?php echo e($user->is_active ? 'إلغاء تفعيل' : 'تفعيل'); ?>

                                    </button>
                                </form>

                                <?php if($user->user_type === 'importer'): ?>
                                    <a href="<?php echo e(route('admin.importers.show', $user->id)); ?>" class="btn btn-info">
                                        <i class="fas fa-truck"></i> عرض في المستوردين
                                    </a>
                                <?php endif; ?>

                                <form method="POST" action="<?php echo e(route('admin.users.destroy', $user)); ?>" 
                                      class="d-inline"
                                      onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i> حذف المستخدم
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\admin\users\show.blade.php ENDPATH**/ ?>