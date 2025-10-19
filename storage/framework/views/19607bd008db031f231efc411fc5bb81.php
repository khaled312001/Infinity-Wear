

<?php $__env->startSection('title', 'تعديل التقرير'); ?>
<?php $__env->startSection('dashboard-title', 'تعديل التقرير'); ?>
<?php $__env->startSection('page-title', 'تعديل تقرير المندوب التسويقي'); ?>
<?php $__env->startSection('page-subtitle', 'تعديل تفاصيل التقرير'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="dashboard-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-edit me-2"></i>
                        تعديل التقرير
                    </h5>
                    <a href="<?php echo e(route('admin.marketing-reports.show', $marketingReport)); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-right me-2"></i>
                        العودة
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('admin.marketing-reports.update', $marketingReport)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">اسم المندوب <span class="text-danger">*</span></label>
                            <input type="text" name="representative_name" class="form-control" value="<?php echo e(old('representative_name', $marketingReport->representative_name)); ?>" required>
                            <?php $__errorArgs = ['representative_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">اسم الشركة <span class="text-danger">*</span></label>
                            <input type="text" name="company_name" class="form-control" value="<?php echo e(old('company_name', $marketingReport->company_name)); ?>" required>
                            <?php $__errorArgs = ['company_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div class="col-12 mb-3">
                            <label class="form-label">عنوان الشركة <span class="text-danger">*</span></label>
                            <textarea name="company_address" class="form-control" rows="2" required><?php echo e(old('company_address', $marketingReport->company_address)); ?></textarea>
                            <?php $__errorArgs = ['company_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">نوع النشاط <span class="text-danger">*</span></label>
                            <select name="company_activity" class="form-select" required>
                                <option value="sports_academy" <?php echo e(old('company_activity', $marketingReport->company_activity) === 'sports_academy' ? 'selected' : ''); ?>>أكاديمية رياضية</option>
                                <option value="school" <?php echo e(old('company_activity', $marketingReport->company_activity) === 'school' ? 'selected' : ''); ?>>مدرسة</option>
                                <option value="institution_company" <?php echo e(old('company_activity', $marketingReport->company_activity) === 'institution_company' ? 'selected' : ''); ?>>مؤسسة / شركة</option>
                                <option value="wholesale_store" <?php echo e(old('company_activity', $marketingReport->company_activity) === 'wholesale_store' ? 'selected' : ''); ?>>محل جملة</option>
                                <option value="retail_store" <?php echo e(old('company_activity', $marketingReport->company_activity) === 'retail_store' ? 'selected' : ''); ?>>محل تجزئة</option>
                                <option value="other" <?php echo e(old('company_activity', $marketingReport->company_activity) === 'other' ? 'selected' : ''); ?>>أخرى</option>
                            </select>
                            <?php $__errorArgs = ['company_activity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">نوع الزيارة <span class="text-danger">*</span></label>
                            <select name="visit_type" class="form-select" required>
                                <option value="office_visit" <?php echo e(old('visit_type', $marketingReport->visit_type) === 'office_visit' ? 'selected' : ''); ?>>زيارة مقر</option>
                                <option value="phone_call" <?php echo e(old('visit_type', $marketingReport->visit_type) === 'phone_call' ? 'selected' : ''); ?>>اتصال</option>
                                <option value="whatsapp" <?php echo e(old('visit_type', $marketingReport->visit_type) === 'whatsapp' ? 'selected' : ''); ?>>رسائل Whatsapp</option>
                            </select>
                            <?php $__errorArgs = ['visit_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">اسم المسؤول <span class="text-danger">*</span></label>
                            <input type="text" name="responsible_name" class="form-control" value="<?php echo e(old('responsible_name', $marketingReport->responsible_name)); ?>" required>
                            <?php $__errorArgs = ['responsible_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">هاتف المسؤول <span class="text-danger">*</span></label>
                            <input type="text" name="responsible_phone" class="form-control" value="<?php echo e(old('responsible_phone', $marketingReport->responsible_phone)); ?>" required>
                            <?php $__errorArgs = ['responsible_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">منصب المسؤول <span class="text-danger">*</span></label>
                            <input type="text" name="responsible_position" class="form-control" value="<?php echo e(old('responsible_position', $marketingReport->responsible_position)); ?>" required>
                            <?php $__errorArgs = ['responsible_position'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">حالة الاتفاق <span class="text-danger">*</span></label>
                            <select name="agreement_status" class="form-select" required>
                                <option value="agreed" <?php echo e(old('agreement_status', $marketingReport->agreement_status) === 'agreed' ? 'selected' : ''); ?>>تم الاتفاق</option>
                                <option value="rejected" <?php echo e(old('agreement_status', $marketingReport->agreement_status) === 'rejected' ? 'selected' : ''); ?>>تم الرفض</option>
                                <option value="needs_time" <?php echo e(old('agreement_status', $marketingReport->agreement_status) === 'needs_time' ? 'selected' : ''); ?>>بحاجة إلى وقت</option>
                            </select>
                            <?php $__errorArgs = ['agreement_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">الكمية المستهدفة <span class="text-danger">*</span></label>
                            <input type="number" name="target_quantity" class="form-control" value="<?php echo e(old('target_quantity', $marketingReport->target_quantity)); ?>" min="0" required>
                            <?php $__errorArgs = ['target_quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">الاستهلاك السنوي <span class="text-danger">*</span></label>
                            <input type="number" name="annual_consumption" class="form-control" value="<?php echo e(old('annual_consumption', $marketingReport->annual_consumption)); ?>" min="0" required>
                            <?php $__errorArgs = ['annual_consumption'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">حالة التقرير <span class="text-danger">*</span></label>
                            <select name="status" class="form-select" required>
                                <option value="pending" <?php echo e(old('status', $marketingReport->status) === 'pending' ? 'selected' : ''); ?>>قيد المراجعة</option>
                                <option value="under_review" <?php echo e(old('status', $marketingReport->status) === 'under_review' ? 'selected' : ''); ?>>قيد المراجعة</option>
                                <option value="approved" <?php echo e(old('status', $marketingReport->status) === 'approved' ? 'selected' : ''); ?>>موافق عليه</option>
                                <option value="rejected" <?php echo e(old('status', $marketingReport->status) === 'rejected' ? 'selected' : ''); ?>>مرفوض</option>
                            </select>
                            <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div class="col-12 mb-3">
                            <label class="form-label">التوصيات <span class="text-danger">*</span></label>
                            <textarea name="recommendations" class="form-control" rows="3" required><?php echo e(old('recommendations', $marketingReport->recommendations)); ?></textarea>
                            <?php $__errorArgs = ['recommendations'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div class="col-12 mb-3">
                            <label class="form-label">الخطوات التالية <span class="text-danger">*</span></label>
                            <textarea name="next_steps" class="form-control" rows="3" required><?php echo e(old('next_steps', $marketingReport->next_steps)); ?></textarea>
                            <?php $__errorArgs = ['next_steps'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div class="col-12 mb-3">
                            <label class="form-label">ملاحظات المندوب</label>
                            <textarea name="notes" class="form-control" rows="3"><?php echo e(old('notes', $marketingReport->notes)); ?></textarea>
                            <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div class="col-12 mb-3">
                            <label class="form-label">ملاحظات الإدارة</label>
                            <textarea name="admin_notes" class="form-control" rows="3"><?php echo e(old('admin_notes', $marketingReport->admin_notes)); ?></textarea>
                            <?php $__errorArgs = ['admin_notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?php echo e(route('admin.marketing-reports.show', $marketingReport)); ?>" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>
                            إلغاء
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            حفظ التغييرات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\admin\marketing-reports\edit.blade.php ENDPATH**/ ?>