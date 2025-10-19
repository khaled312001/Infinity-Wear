

<?php $__env->startSection('title', 'تعديل الخدمة'); ?>
<?php $__env->startSection('page-title', 'تعديل الخدمة'); ?>
<?php $__env->startSection('page-subtitle', 'تعديل بيانات الخدمة'); ?>


<?php $__env->startSection('content'); ?>
<script>
// Define functions immediately to ensure they're available
window.addFeature = function() {
    const container = document.getElementById('featuresContainer');
    if (!container) return;
    
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `
        <input type="text" class="form-control" name="features[]" placeholder="أدخل ميزة">
        <button type="button" class="btn btn-outline-danger" data-action="remove-feature">
            <i class="fas fa-trash"></i>
        </button>
    `;
    container.appendChild(div);
};

window.removeFeature = function(button) {
    if (button && button.parentElement) {
        button.parentElement.remove();
    }
};

// Also define as regular functions for backward compatibility
function addFeature() {
    window.addFeature();
}

function removeFeature(button) {
    window.removeFeature(button);
}

console.log('Feature functions defined at page start');

// Add event delegation for dynamic buttons
document.addEventListener('click', function(e) {
    if (e.target.closest('button[data-action="remove-feature"]')) {
        e.preventDefault();
        const button = e.target.closest('button[data-action="remove-feature"]');
        removeFeature(button);
    }
    
    if (e.target.closest('button[data-action="add-feature"]')) {
        e.preventDefault();
        addFeature();
    }
    
    // Fallback for onclick attributes
    if (e.target.closest('button[onclick*="removeFeature"]')) {
        e.preventDefault();
        const button = e.target.closest('button[onclick*="removeFeature"]');
        removeFeature(button);
    }
    
    if (e.target.closest('button[onclick*="addFeature"]')) {
        e.preventDefault();
        addFeature();
    }
});
</script>

<div class="row">
    <div class="col-12">
        <div class="card dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-edit me-2"></i>
                    تعديل الخدمة: <?php echo e($service->title); ?>

                </h5>
                <?php if(session('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <?php echo e(session('success')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('admin.services.update', $service->id)); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="title" class="form-label">عنوان الخدمة <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" value="<?php echo e(old('title', $service->title)); ?>" required>
                                <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="icon" class="form-label">الأيقونة</label>
                                <input type="text" class="form-control" id="icon" name="icon" 
                                       value="<?php echo e(old('icon', $service->icon)); ?>"
                                       placeholder="مثال: fas fa-tshirt">
                                <small class="form-text text-muted">استخدم Font Awesome icons</small>
                                <?php $__errorArgs = ['icon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">وصف الخدمة <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="description" name="description" rows="3" required><?php echo e(old('description', $service->description)); ?></textarea>
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <div class="mb-3">
                        <label for="image" class="form-label">صورة الخدمة</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/jpeg,image/jpg,image/png,image/gif,image/svg+xml">
                        <small class="form-text text-muted">اترك فارغاً للاحتفاظ بالصورة الحالية. الصور المقبولة: JPEG, JPG, PNG, GIF, SVG (حد أقصى 2MB)</small>
                        <?php if($service->image): ?>
                            <div class="mt-2">
                                <small class="text-muted">الصورة الحالية:</small><br>
                                <img src="<?php echo e($service->image_url); ?>" alt="<?php echo e($service->title); ?>" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                            </div>
                        <?php endif; ?>
                        <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">ميزات الخدمة</label>
                        <div id="featuresContainer">
                            <?php if($service->features && count($service->features) > 0): ?>
                                <?php $__currentLoopData = $service->features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="features[]" value="<?php echo e($feature); ?>">
                                        <button type="button" class="btn btn-outline-danger" data-action="remove-feature" onclick="if(typeof removeFeature === 'function') removeFeature(this); else console.error('removeFeature not defined');">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="features[]" placeholder="أدخل ميزة">
                                    <button type="button" class="btn btn-outline-danger" data-action="remove-feature" onclick="if(typeof removeFeature === 'function') removeFeature(this); else console.error('removeFeature not defined');">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            <?php endif; ?>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-action="add-feature" id="addFeatureBtn" onclick="if(typeof addFeature === 'function') addFeature(); else console.error('addFeature not defined');">
                            <i class="fas fa-plus me-1"></i> إضافة ميزة
                        </button>
                        <?php $__errorArgs = ['features'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="order" class="form-label">ترتيب العرض</label>
                                <input type="number" class="form-control" id="order" name="order" min="0" value="<?php echo e(old('order', $service->order)); ?>">
                                <?php $__errorArgs = ['order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                           <?php echo e(old('is_active', $service->is_active) ? 'checked' : ''); ?>>
                                    <input type="hidden" name="is_active" value="0">
                                    <label class="form-check-label" for="is_active">
                                        تفعيل الخدمة
                                    </label>
                                </div>
                                <?php $__errorArgs = ['is_active'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="meta_title" class="form-label">عنوان SEO</label>
                        <input type="text" class="form-control" id="meta_title" name="meta_title" value="<?php echo e(old('meta_title', $service->meta_title)); ?>">
                        <?php $__errorArgs = ['meta_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <div class="mb-3">
                        <label for="meta_description" class="form-label">وصف SEO</label>
                        <textarea class="form-control" id="meta_description" name="meta_description" rows="2"><?php echo e(old('meta_description', $service->meta_description)); ?></textarea>
                        <?php $__errorArgs = ['meta_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            حفظ التغييرات
                        </button>
                        <a href="<?php echo e(route('admin.services.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            العودة للقائمة
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
// Ensure functions are available globally
window.addFeature = function() {
    const container = document.getElementById('featuresContainer');
    if (!container) return;
    
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `
        <input type="text" class="form-control" name="features[]" placeholder="أدخل ميزة">
        <button type="button" class="btn btn-outline-danger" onclick="removeFeature(this)">
            <i class="fas fa-trash"></i>
        </button>
    `;
    container.appendChild(div);
};

window.removeFeature = function(button) {
    if (button && button.parentElement) {
        button.parentElement.remove();
    }
};

// Also define as regular functions for backward compatibility
function addFeature() {
    window.addFeature();
}

function removeFeature(button) {
    window.removeFeature(button);
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('Services edit page loaded');
    console.log('addFeature function available:', typeof window.addFeature);
    console.log('removeFeature function available:', typeof window.removeFeature);
    
    // Ensure all remove buttons work
    const removeButtons = document.querySelectorAll('button[onclick*="removeFeature"]');
    removeButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            removeFeature(this);
        });
    });
    
    // Ensure add button works
    const addButton = document.getElementById('addFeatureBtn');
    if (addButton) {
        addButton.addEventListener('click', function(e) {
            e.preventDefault();
            addFeature();
        });
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\admin\services\edit.blade.php ENDPATH**/ ?>