

<?php $__env->startSection('title', 'إنشاء إشعار جديد'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-plus me-2"></i>
                        إنشاء إشعار جديد
                    </h1>
                    <p class="text-muted">إرسال إشعار أو إيميل للمستخدمين</p>
                </div>
                <a href="<?php echo e(route('admin.notifications.index')); ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-right me-2"></i>
                    العودة للقائمة
                </a>
            </div>
        </div>
    </div>

    <form method="POST" action="<?php echo e(route('admin.notifications.store')); ?>" id="notificationForm">
        <?php echo csrf_field(); ?>
        
        <div class="row">
            <!-- Basic Information -->
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">معلومات الإشعار</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title" class="font-weight-bold">عنوان الإشعار <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="title" name="title" value="<?php echo e(old('title')); ?>" 
                                           placeholder="أدخل عنوان الإشعار" required>
                                    <?php $__errorArgs = ['title'];
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category" class="font-weight-bold">الفئة</label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="category" name="category" value="<?php echo e(old('category')); ?>" 
                                           placeholder="مثال: تسويق، إعلان، تنبيه">
                                    <?php $__errorArgs = ['category'];
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
                        </div>

                        <div class="form-group">
                            <label for="message" class="font-weight-bold">محتوى الإشعار <span class="text-danger">*</span></label>
                            <textarea class="form-control <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                      id="message" name="message" rows="4" 
                                      placeholder="أدخل محتوى الإشعار" required><?php echo e(old('message')); ?></textarea>
                            <?php $__errorArgs = ['message'];
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

                        <div class="form-group">
                            <label for="email_content" class="font-weight-bold">محتوى الإيميل</label>
                            <textarea class="form-control <?php $__errorArgs = ['email_content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                      id="email_content" name="email_content" rows="6" 
                                      placeholder="أدخل محتوى الإيميل (اختياري)"><?php echo e(old('email_content')); ?></textarea>
                            <small class="form-text text-muted">هذا المحتوى سيظهر في الإيميل فقط</small>
                            <?php $__errorArgs = ['email_content'];
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
                </div>

                <!-- Target Selection -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">اختيار المستهدفين</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="font-weight-bold">نوع المستهدفين <span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="target_type" 
                                               id="target_all" value="all" <?php echo e(old('target_type') == 'all' ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="target_all">
                                            <i class="fas fa-users me-2"></i>جميع المستخدمين
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="target_type" 
                                               id="target_user_type" value="user_type" <?php echo e(old('target_type') == 'user_type' ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="target_user_type">
                                            <i class="fas fa-user-tag me-2"></i>نوع مستخدم محدد
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="target_type" 
                                               id="target_specific" value="specific_users" <?php echo e(old('target_type') == 'specific_users' ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="target_specific">
                                            <i class="fas fa-user-check me-2"></i>مستخدمين محددين
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <?php $__errorArgs = ['target_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-2"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- User Types Selection -->
                        <div id="user_types_section" class="form-group" style="display: none;">
                            <label class="font-weight-bold">اختيار أنواع المستخدمين</label>
                            <div class="row">
                                <?php $__currentLoopData = $userTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input user-type-checkbox" type="checkbox" 
                                                   name="target_user_types[]" value="<?php echo e($type); ?>" 
                                                   id="user_type_<?php echo e($type); ?>"
                                                   <?php echo e(in_array($type, old('target_user_types', [])) ? 'checked' : ''); ?>>
                                            <label class="form-check-label" for="user_type_<?php echo e($type); ?>">
                                                <?php echo e($label); ?>

                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <?php $__errorArgs = ['target_user_types'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-2"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Specific Users Selection -->
                        <div id="specific_users_section" class="form-group" style="display: none;">
                            <label class="font-weight-bold">اختيار المستخدمين</label>
                            <div class="row">
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userType => $typeUsers): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-6 mb-3">
                                        <h6 class="text-primary"><?php echo e($userTypes[$userType] ?? $userType); ?></h6>
                                        <div style="max-height: 200px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; border-radius: 5px;">
                                            <?php $__currentLoopData = $typeUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="form-check">
                                                    <input class="form-check-input specific-user-checkbox" type="checkbox" 
                                                           name="target_users[]" value="<?php echo e($user->id); ?>" 
                                                           id="user_<?php echo e($user->id); ?>"
                                                           <?php echo e(in_array($user->id, old('target_users', [])) ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="user_<?php echo e($user->id); ?>">
                                                        <?php echo e($user->name); ?> (<?php echo e($user->email); ?>)
                                                    </label>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <?php $__errorArgs = ['target_users'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-2"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings Sidebar -->
            <div class="col-lg-4">
                <!-- Send Type -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">نوع الإرسال</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="font-weight-bold">طريقة الإرسال <span class="text-danger">*</span></label>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="type" 
                                       id="type_notification" value="notification" <?php echo e(old('type', 'notification') == 'notification' ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="type_notification">
                                    <i class="fas fa-bell me-2"></i>إشعار فقط
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="type" 
                                       id="type_email" value="email" <?php echo e(old('type') == 'email' ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="type_email">
                                    <i class="fas fa-envelope me-2"></i>إيميل فقط
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type" 
                                       id="type_both" value="both" <?php echo e(old('type') == 'both' ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="type_both">
                                    <i class="fas fa-bell me-2"></i><i class="fas fa-envelope me-2"></i>إشعار وإيميل
                                </label>
                            </div>
                            <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-2"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <!-- Priority -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">الأولوية</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="font-weight-bold">أولوية الإشعار <span class="text-danger">*</span></label>
                            <select name="priority" id="priority" class="form-control <?php $__errorArgs = ['priority'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="low" <?php echo e(old('priority', 'normal') == 'low' ? 'selected' : ''); ?>>منخفضة</option>
                                <option value="normal" <?php echo e(old('priority', 'normal') == 'normal' ? 'selected' : ''); ?>>عادية</option>
                                <option value="high" <?php echo e(old('priority') == 'high' ? 'selected' : ''); ?>>عالية</option>
                                <option value="urgent" <?php echo e(old('priority') == 'urgent' ? 'selected' : ''); ?>>عاجلة</option>
                            </select>
                            <?php $__errorArgs = ['priority'];
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
                </div>

                <!-- Scheduling -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">جدولة الإرسال</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_scheduled" 
                                       id="is_scheduled" value="1" <?php echo e(old('is_scheduled') ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="is_scheduled">
                                    جدولة الإرسال
                                </label>
                            </div>
                        </div>
                        
                        <div id="scheduling_section" class="form-group" style="display: none;">
                            <label for="scheduled_at" class="font-weight-bold">تاريخ ووقت الإرسال</label>
                            <input type="datetime-local" class="form-control <?php $__errorArgs = ['scheduled_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="scheduled_at" name="scheduled_at" 
                                   value="<?php echo e(old('scheduled_at')); ?>"
                                   min="<?php echo e(now()->format('Y-m-d\TH:i')); ?>">
                            <?php $__errorArgs = ['scheduled_at'];
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
                </div>

                <!-- Preview -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">معاينة الإشعار</h6>
                    </div>
                    <div class="card-body">
                        <div id="notification_preview" class="border rounded p-3 bg-light">
                            <div class="text-center text-muted">
                                <i class="fas fa-eye fa-2x mb-2"></i>
                                <p>ستظهر معاينة الإشعار هنا</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <button type="submit" class="btn btn-primary btn-lg me-3">
                            <i class="fas fa-paper-plane me-2"></i>
                            إرسال الإشعار
                        </button>
                        <a href="<?php echo e(route('admin.notifications.index')); ?>" class="btn btn-secondary btn-lg">
                            <i class="fas fa-times me-2"></i>
                            إلغاء
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function() {
    // Handle target type change
    $('input[name="target_type"]').change(function() {
        const targetType = $(this).val();
        
        // Hide all sections
        $('#user_types_section, #specific_users_section').hide();
        
        // Show relevant section
        if (targetType === 'user_type') {
            $('#user_types_section').show();
        } else if (targetType === 'specific_users') {
            $('#specific_users_section').show();
        }
    });

    // Handle scheduling checkbox
    $('#is_scheduled').change(function() {
        if ($(this).is(':checked')) {
            $('#scheduling_section').show();
        } else {
            $('#scheduling_section').hide();
        }
    });

    // Handle send type change
    $('input[name="type"]').change(function() {
        updatePreview();
    });

    // Update preview on input change
    $('#title, #message, #email_content, #priority').on('input change', function() {
        updatePreview();
    });

    // Initialize on page load
    $('input[name="target_type"]:checked').trigger('change');
    $('#is_scheduled').trigger('change');
    updatePreview();

    function updatePreview() {
        const title = $('#title').val() || 'عنوان الإشعار';
        const message = $('#message').val() || 'محتوى الإشعار';
        const priority = $('#priority').val();
        const type = $('input[name="type"]:checked').val();
        
        const priorityLabels = {
            'low': 'منخفضة',
            'normal': 'عادية',
            'high': 'عالية',
            'urgent': 'عاجلة'
        };
        
        const typeLabels = {
            'notification': 'إشعار فقط',
            'email': 'إيميل فقط',
            'both': 'إشعار وإيميل'
        };
        
        const priorityColors = {
            'low': 'success',
            'normal': 'primary',
            'high': 'warning',
            'urgent': 'danger'
        };
        
        const preview = `
            <div class="notification-preview">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0 font-weight-bold">${title}</h6>
                    <span class="badge badge-${priorityColors[priority]} badge-sm">${priorityLabels[priority]}</span>
                </div>
                <p class="mb-2">${message}</p>
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">${typeLabels[type]}</small>
                    <small class="text-muted">الآن</small>
                </div>
            </div>
        `;
        
        $('#notification_preview').html(preview);
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\admin\notifications\create.blade.php ENDPATH**/ ?>