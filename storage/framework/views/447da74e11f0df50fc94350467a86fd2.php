

<?php $__env->startSection('title', 'تقرير مندوب تسويقي جديد'); ?>
<?php $__env->startSection('dashboard-title', 'تقرير مندوب تسويقي جديد'); ?>
<?php $__env->startSection('page-title', 'تقرير مندوب تسويقي جديد'); ?>
<?php $__env->startSection('page-subtitle', 'إنشاء تقرير جديد للمندوب التسويقي'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-plus me-2"></i>
                    تقرير مندوب تسويقي جديد
                </h5>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('sales.marketing-reports.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    
                    <div class="row">
                        <!-- معلومات المندوب -->
                        <div class="col-12 mb-4">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-user me-2"></i>
                                معلومات المندوب
                            </h6>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">اسم المندوب <span class="text-danger">*</span></label>
                            <select name="representative_name" class="form-select <?php $__errorArgs = ['representative_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="">اختر المندوب</option>
                                <option value="عمرو الدسوقي" <?php echo e(old('representative_name') == 'عمرو الدسوقي' ? 'selected' : ''); ?>>عمرو الدسوقي</option>
                                <option value="محمد علي" <?php echo e(old('representative_name') == 'محمد علي' ? 'selected' : ''); ?>>محمد علي</option>
                            </select>
                            <?php $__errorArgs = ['representative_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- معلومات الجهة -->
                        <div class="col-12 mb-4 mt-4">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-building me-2"></i>
                                معلومات الجهة
                            </h6>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">اسم الجهة <span class="text-danger">*</span></label>
                            <input type="text" name="company_name" class="form-control <?php $__errorArgs = ['company_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('company_name')); ?>" required>
                            <?php $__errorArgs = ['company_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">نشاط الجهة <span class="text-danger">*</span></label>
                            <select name="company_activity" class="form-select <?php $__errorArgs = ['company_activity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="">اختر نشاط الجهة</option>
                                <option value="sports_academy" <?php echo e(old('company_activity') == 'sports_academy' ? 'selected' : ''); ?>>أكاديمية رياضية</option>
                                <option value="school" <?php echo e(old('company_activity') == 'school' ? 'selected' : ''); ?>>مدرسة</option>
                                <option value="institution_company" <?php echo e(old('company_activity') == 'institution_company' ? 'selected' : ''); ?>>مؤسسة / شركة</option>
                                <option value="wholesale_store" <?php echo e(old('company_activity') == 'wholesale_store' ? 'selected' : ''); ?>>محل جملة</option>
                                <option value="retail_store" <?php echo e(old('company_activity') == 'retail_store' ? 'selected' : ''); ?>>محل تجزئة</option>
                                <option value="other" <?php echo e(old('company_activity') == 'other' ? 'selected' : ''); ?>>أخرى</option>
                            </select>
                            <?php $__errorArgs = ['company_activity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">عنوان الجهة التفصيلي <span class="text-danger">*</span></label>
                            <textarea name="company_address" class="form-control <?php $__errorArgs = ['company_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                      rows="3" required><?php echo e(old('company_address')); ?></textarea>
                            <?php $__errorArgs = ['company_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">صورة المكان الذي تم زيارته</label>
                            <input type="file" name="company_images[]" class="form-control <?php $__errorArgs = ['company_images.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   multiple accept="image/*">
                            <div class="form-text">يمكنك تحميل ما يصل إلى 5 ملفات متوافقة. الحد الأقصى هو 10 MB لكل ملف.</div>
                            <?php $__errorArgs = ['company_images.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- معلومات المسئول -->
                        <div class="col-12 mb-4 mt-4">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-user-tie me-2"></i>
                                معلومات المسئول
                            </h6>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">اسم المسئول <span class="text-danger">*</span></label>
                            <input type="text" name="responsible_name" class="form-control <?php $__errorArgs = ['responsible_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('responsible_name')); ?>" required>
                            <?php $__errorArgs = ['responsible_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">رقم الجوال <span class="text-danger">*</span></label>
                            <input type="tel" name="responsible_phone" class="form-control <?php $__errorArgs = ['responsible_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('responsible_phone')); ?>" required>
                            <?php $__errorArgs = ['responsible_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">المنصب <span class="text-danger">*</span></label>
                            <input type="text" name="responsible_position" class="form-control <?php $__errorArgs = ['responsible_position'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('responsible_position')); ?>" required>
                            <?php $__errorArgs = ['responsible_position'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- تفاصيل الزيارة -->
                        <div class="col-12 mb-4 mt-4">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-calendar-check me-2"></i>
                                تفاصيل الزيارة
                            </h6>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">نوع الزيارة <span class="text-danger">*</span></label>
                            <select name="visit_type" class="form-select <?php $__errorArgs = ['visit_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="">اختر نوع الزيارة</option>
                                <option value="office_visit" <?php echo e(old('visit_type') == 'office_visit' ? 'selected' : ''); ?>>زيارة مقر</option>
                                <option value="phone_call" <?php echo e(old('visit_type') == 'phone_call' ? 'selected' : ''); ?>>اتصال</option>
                                <option value="whatsapp" <?php echo e(old('visit_type') == 'whatsapp' ? 'selected' : ''); ?>>رسائل Whatsapp</option>
                            </select>
                            <?php $__errorArgs = ['visit_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">حالة الاتفاق <span class="text-danger">*</span></label>
                            <select name="agreement_status" class="form-select <?php $__errorArgs = ['agreement_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="">اختر حالة الاتفاق</option>
                                <option value="agreed" <?php echo e(old('agreement_status') == 'agreed' ? 'selected' : ''); ?>>تم الاتفاق</option>
                                <option value="rejected" <?php echo e(old('agreement_status') == 'rejected' ? 'selected' : ''); ?>>تم الرفض</option>
                                <option value="needs_time" <?php echo e(old('agreement_status') == 'needs_time' ? 'selected' : ''); ?>>بحاجة إلى وقت</option>
                            </select>
                            <?php $__errorArgs = ['agreement_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">مخاوف العميل</label>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="customer_concerns[]" value="الخامة" 
                                               <?php echo e(in_array('الخامة', old('customer_concerns', [])) ? 'checked' : ''); ?>>
                                        <label class="form-check-label">الخامة</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="customer_concerns[]" value="الجودة" 
                                               <?php echo e(in_array('الجودة', old('customer_concerns', [])) ? 'checked' : ''); ?>>
                                        <label class="form-check-label">الجودة</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="customer_concerns[]" value="وقت التسليم" 
                                               <?php echo e(in_array('وقت التسليم', old('customer_concerns', [])) ? 'checked' : ''); ?>>
                                        <label class="form-check-label">وقت التسليم</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="customer_concerns[]" value="السعر" 
                                               <?php echo e(in_array('السعر', old('customer_concerns', [])) ? 'checked' : ''); ?>>
                                        <label class="form-check-label">السعر</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2">
                                <input type="text" name="customer_concerns[]" class="form-control" placeholder="أخرى:" 
                                       value="<?php echo e(old('customer_concerns.4')); ?>">
                            </div>
                        </div>

                        <!-- التفاصيل التجارية -->
                        <div class="col-12 mb-4 mt-4">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-chart-line me-2"></i>
                                التفاصيل التجارية
                            </h6>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">الكمية المستهدفة <span class="text-danger">*</span></label>
                            <input type="text" name="target_quantity" class="form-control <?php $__errorArgs = ['target_quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('target_quantity')); ?>" required>
                            <?php $__errorArgs = ['target_quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">الاستهلاك السنوي أو عدد الطلبيات السنوية المتوقعة <span class="text-danger">*</span></label>
                            <input type="text" name="annual_consumption" class="form-control <?php $__errorArgs = ['annual_consumption'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('annual_consumption')); ?>" required>
                            <?php $__errorArgs = ['annual_consumption'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- التوصيات والخطوات -->
                        <div class="col-12 mb-4 mt-4">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-lightbulb me-2"></i>
                                التوصيات والخطوات
                            </h6>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">توصيات مقترحة وملاحظات</label>
                            <textarea name="recommendations" class="form-control <?php $__errorArgs = ['recommendations'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                      rows="4"><?php echo e(old('recommendations')); ?></textarea>
                            <?php $__errorArgs = ['recommendations'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">الخطوات اللاحقة التي ستم تنفيذها مع هذا العميل</label>
                            <textarea name="next_steps" class="form-control <?php $__errorArgs = ['next_steps'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                      rows="4"><?php echo e(old('next_steps')); ?></textarea>
                            <?php $__errorArgs = ['next_steps'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">ملاحظات إضافية</label>
                            <textarea name="notes" class="form-control <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                      rows="3"><?php echo e(old('notes')); ?></textarea>
                            <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?php echo e(route('sales.marketing-reports.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>
                            إلغاء
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            حفظ التقرير
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.sales-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\sales\marketing-reports\create.blade.php ENDPATH**/ ?>