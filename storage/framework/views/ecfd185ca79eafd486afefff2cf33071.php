<?php $__env->startSection('title', 'تعديل المستخدم'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Header Section -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">تعديل المستخدم</h1>
                    <p class="text-muted">تعديل بيانات المستخدم: <?php echo e($user->name); ?></p>
                </div>
                <div>
                    <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-right"></i> العودة للقائمة
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">بيانات المستخدم</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?php echo e(route('admin.users.update', $user)); ?>" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                
                                <div class="row">
                                    <!-- الاسم -->
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">الاسم <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               id="name" name="name" value="<?php echo e(old('name', $user->name)); ?>" required>
                                        <?php $__errorArgs = ['name'];
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

                                    <!-- البريد الإلكتروني -->
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">البريد الإلكتروني <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               id="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" required>
                                        <?php $__errorArgs = ['email'];
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

                                    <!-- كلمة المرور -->
                                    <div class="col-md-6 mb-3">
                                        <label for="password" class="form-label">كلمة المرور الجديدة</label>
                                        <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               id="password" name="password">
                                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <div class="form-text">اتركها فارغة إذا كنت لا تريد تغيير كلمة المرور</div>
                                    </div>

                                    <!-- تأكيد كلمة المرور -->
                                    <div class="col-md-6 mb-3">
                                        <label for="password_confirmation" class="form-label">تأكيد كلمة المرور الجديدة</label>
                                        <input type="password" class="form-control" 
                                               id="password_confirmation" name="password_confirmation">
                                    </div>

                                    <!-- نوع المستخدم -->
                                    <div class="col-md-6 mb-3">
                                        <label for="user_type" class="form-label">نوع المستخدم <span class="text-danger">*</span></label>
                                        <select class="form-select <?php $__errorArgs = ['user_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                id="user_type" name="user_type" required onchange="toggleUserTypeFields()">
                                            <option value="">اختر نوع المستخدم</option>
                                            <?php $__currentLoopData = $userTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($value); ?>" <?php echo e(old('user_type', $user->user_type) == $value ? 'selected' : ''); ?>>
                                                    <?php echo e($label); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php $__errorArgs = ['user_type'];
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

                                    <!-- رقم الهاتف -->
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">رقم الهاتف</label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               id="phone" name="phone" value="<?php echo e(old('phone', $user->phone)); ?>">
                                        <?php $__errorArgs = ['phone'];
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

                                    <!-- المدينة -->
                                    <div class="col-md-6 mb-3">
                                        <label for="city" class="form-label">المدينة</label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               id="city" name="city" value="<?php echo e(old('city', $user->city)); ?>">
                                        <?php $__errorArgs = ['city'];
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

                                    <!-- العنوان -->
                                    <div class="col-md-6 mb-3">
                                        <label for="address" class="form-label">العنوان</label>
                                        <textarea class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                  id="address" name="address" rows="3"><?php echo e(old('address', $user->address)); ?></textarea>
                                        <?php $__errorArgs = ['address'];
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

                                    <!-- الصورة الشخصية -->
                                    <div class="col-md-6 mb-3">
                                        <label for="avatar" class="form-label">الصورة الشخصية</label>
                                        <?php if($user->avatar): ?>
                                            <div class="mb-2">
                                                <img src="<?php echo e(asset('storage/' . $user->avatar)); ?>" 
                                                     alt="<?php echo e($user->name); ?>" 
                                                     class="rounded-circle" 
                                                     width="60" height="60">
                                                <small class="text-muted d-block">الصورة الحالية</small>
                                            </div>
                                        <?php endif; ?>
                                        <input type="file" class="form-control <?php $__errorArgs = ['avatar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               id="avatar" name="avatar" accept="image/*">
                                        <?php $__errorArgs = ['avatar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <div class="form-text">الحد الأقصى: 2MB، الأنواع المسموحة: JPG, PNG, GIF</div>
                                    </div>

                                    <!-- نبذة شخصية -->
                                    <div class="col-md-6 mb-3">
                                        <label for="bio" class="form-label">نبذة شخصية</label>
                                        <textarea class="form-control <?php $__errorArgs = ['bio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                  id="bio" name="bio" rows="3"><?php echo e(old('bio', $user->bio)); ?></textarea>
                                        <?php $__errorArgs = ['bio'];
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

                                    <!-- الحالة -->
                                    <div class="col-md-6 mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                                   value="1" <?php echo e(old('is_active', $user->is_active) ? 'checked' : ''); ?>>
                                            <label class="form-check-label" for="is_active">
                                                تفعيل المستخدم
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- حقول إضافية حسب نوع المستخدم -->
                                <div id="importer-fields" style="display: none;">
                                    <hr>
                                    <h6 class="text-primary">بيانات المستورد</h6>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="company_name" class="form-label">اسم الشركة</label>
                                            <input type="text" class="form-control" id="company_name" name="company_name" 
                                                   value="<?php echo e(old('company_name', $user->importer->company_name ?? '')); ?>">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="company_type" class="form-label">نوع الشركة</label>
                                            <select class="form-select" id="company_type" name="company_type">
                                                <option value="">اختر نوع الشركة</option>
                                                <option value="individual" <?php echo e(old('company_type', $user->importer->company_type ?? '') == 'individual' ? 'selected' : ''); ?>>فرد</option>
                                                <option value="company" <?php echo e(old('company_type', $user->importer->company_type ?? '') == 'company' ? 'selected' : ''); ?>>شركة</option>
                                                <option value="institution" <?php echo e(old('company_type', $user->importer->company_type ?? '') == 'institution' ? 'selected' : ''); ?>>مؤسسة</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="business_license" class="form-label">رقم السجل التجاري</label>
                                            <input type="text" class="form-control" id="business_license" name="business_license" 
                                                   value="<?php echo e(old('business_license', $user->importer->business_license ?? '')); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div id="marketing-fields" style="display: none;">
                                    <hr>
                                    <h6 class="text-primary">بيانات فريق التسويق</h6>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="department" class="form-label">القسم</label>
                                            <input type="text" class="form-control" id="department" name="department" 
                                                   value="<?php echo e(old('department', $user->marketingTeam->department ?? 'تسويق')); ?>">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="position" class="form-label">المنصب</label>
                                            <input type="text" class="form-control" id="position" name="position" 
                                                   value="<?php echo e(old('position', $user->marketingTeam->position ?? 'موظف تسويق')); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div id="sales-fields" style="display: none;">
                                    <hr>
                                    <h6 class="text-primary">بيانات فريق المبيعات</h6>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="department" class="form-label">القسم</label>
                                            <input type="text" class="form-control" id="department" name="department" 
                                                   value="<?php echo e(old('department', $user->salesTeam->department ?? 'مبيعات')); ?>">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="position" class="form-label">المنصب</label>
                                            <input type="text" class="form-control" id="position" name="position" 
                                                   value="<?php echo e(old('position', $user->salesTeam->position ?? 'مندوب مبيعات')); ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> إلغاء
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> حفظ التغييرات
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">معلومات المستخدم</h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <?php if($user->avatar): ?>
                                    <img src="<?php echo e(asset('storage/' . $user->avatar)); ?>" 
                                         alt="<?php echo e($user->name); ?>" 
                                         class="rounded-circle mb-2" 
                                         width="80" height="80">
                                <?php else: ?>
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" 
                                         style="width: 80px; height: 80px;">
                                        <?php echo e(substr($user->name, 0, 1)); ?>

                                    </div>
                                <?php endif; ?>
                                <h5><?php echo e($user->name); ?></h5>
                                <p class="text-muted"><?php echo e($user->getUserTypeLabelAttribute()); ?></p>
                            </div>

                            <div class="list-group list-group-flush">
                                <div class="list-group-item d-flex justify-content-between">
                                    <span>تاريخ الإنشاء:</span>
                                    <span><?php echo e($user->created_at->format('Y-m-d')); ?></span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between">
                                    <span>آخر تحديث:</span>
                                    <span><?php echo e($user->updated_at->format('Y-m-d')); ?></span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between">
                                    <span>الحالة:</span>
                                    <span class="badge bg-<?php echo e($user->is_active ? 'success' : 'danger'); ?>">
                                        <?php echo e($user->is_active ? 'نشط' : 'غير نشط'); ?>

                                    </span>
                                </div>
                            </div>

                            <div class="alert alert-warning mt-3">
                                <h6><i class="fas fa-exclamation-triangle"></i> تحذير</h6>
                                <p class="mb-0">تغيير نوع المستخدم قد يؤثر على صلاحياته وبياناته المرتبطة.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    function toggleUserTypeFields() {
        const userType = document.getElementById('user_type').value;
        
        // إخفاء جميع الحقول الإضافية
        document.getElementById('importer-fields').style.display = 'none';
        document.getElementById('marketing-fields').style.display = 'none';
        document.getElementById('sales-fields').style.display = 'none';
        
        // إظهار الحقول المناسبة
        if (userType === 'importer') {
            document.getElementById('importer-fields').style.display = 'block';
        } else if (userType === 'marketing') {
            document.getElementById('marketing-fields').style.display = 'block';
        } else if (userType === 'sales') {
            document.getElementById('sales-fields').style.display = 'block';
        }
    }

    // تشغيل الدالة عند تحميل الصفحة
    document.addEventListener('DOMContentLoaded', function() {
        toggleUserTypeFields();
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\admin\users\edit.blade.php ENDPATH**/ ?>