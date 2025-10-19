<?php
use Illuminate\Support\Facades\Storage;
?>

<?php $__env->startSection('title', 'تحرير العمل: ' . $portfolioItem->title); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>تحرير العمل: <?php echo e($portfolioItem->title); ?></h1>
        <a href="<?php echo e(route('admin.portfolio.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> العودة
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="<?php echo e(route('admin.portfolio.update', $portfolioItem->id)); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="title" class="form-label">العنوان *</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="title" name="title" value="<?php echo e(old('title', $portfolioItem->title)); ?>" required>
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

                        <div class="mb-3">
                            <label for="description" class="form-label">الوصف *</label>
                            <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                      id="description" name="description" rows="4" required><?php echo e(old('description', $portfolioItem->description)); ?></textarea>
                            <?php $__errorArgs = ['description'];
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

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="client_name" class="form-label">اسم العميل *</label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['client_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="client_name" name="client_name" value="<?php echo e(old('client_name', $portfolioItem->client_name)); ?>" required>
                                    <?php $__errorArgs = ['client_name'];
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
                                <div class="mb-3">
                                    <label for="completion_date" class="form-label">تاريخ الإنجاز *</label>
                                    <input type="date" class="form-control <?php $__errorArgs = ['completion_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="completion_date" name="completion_date" value="<?php echo e(old('completion_date', $portfolioItem->completion_date ? $portfolioItem->completion_date->format('Y-m-d') : '')); ?>" required>
                                    <?php $__errorArgs = ['completion_date'];
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

                        <div class="mb-3">
                            <label for="category" class="form-label">الفئة *</label>
                            <select class="form-control <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="category" name="category" required>
                                <option value="">اختر الفئة</option>
                                <option value="ملابس رياضية" <?php echo e(old('category', $portfolioItem->category) == 'ملابس رياضية' ? 'selected' : ''); ?>>ملابس رياضية</option>
                                <option value="ملابس مدرسية" <?php echo e(old('category', $portfolioItem->category) == 'ملابس مدرسية' ? 'selected' : ''); ?>>ملابس مدرسية</option>
                                <option value="ملابس طبية" <?php echo e(old('category', $portfolioItem->category) == 'ملابس طبية' ? 'selected' : ''); ?>>ملابس طبية</option>
                                <option value="ملابس شركات" <?php echo e(old('category', $portfolioItem->category) == 'ملابس شركات' ? 'selected' : ''); ?>>ملابس شركات</option>
                                <option value="أزياء موحدة" <?php echo e(old('category', $portfolioItem->category) == 'أزياء موحدة' ? 'selected' : ''); ?>>أزياء موحدة</option>
                                <option value="أخرى" <?php echo e(old('category', $portfolioItem->category) == 'أخرى' ? 'selected' : ''); ?>>أخرى</option>
                            </select>
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

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="image" class="form-label">الصورة الرئيسية</label>
                            <input type="file" class="form-control <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="image" name="image" accept="image/*" onchange="validateImage(this)">
                            <?php if($portfolioItem->image): ?>
                                <div class="mt-2">
                                    <small class="text-muted">الصورة الحالية:</small><br>
                                    <img src="<?php echo e($portfolioItem->image_url); ?>" alt="Current image" 
                                         class="img-thumbnail portfolio-image" style="max-width: 200px; max-height: 200px;">
                                </div>
                            <?php endif; ?>
                            <?php $__errorArgs = ['image'];
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

                        <div class="mb-3">
                            <label for="gallery" class="form-label">معرض الصور</label>
                            <input type="file" class="form-control <?php $__errorArgs = ['gallery.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="gallery" name="gallery[]" accept="image/*" multiple onchange="validateGallery(this)">
                            <small class="form-text text-muted">يمكنك اختيار عدة صور</small>
                            <?php $__errorArgs = ['gallery.*'];
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

                        <?php if($portfolioItem->gallery && count($portfolioItem->gallery) > 0): ?>
                            <div class="mb-3">
                                <label class="form-label">الصور الحالية في المعرض</label>
                                <div class="row">
                                    <?php $__currentLoopData = $portfolioItem->gallery_urls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $galleryImageUrl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-6 mb-2">
                                            <div class="position-relative">
                                                <img src="<?php echo e($galleryImageUrl); ?>" alt="Gallery image" 
                                                     class="img-thumbnail portfolio-gallery-image" style="width: 100%; height: 80px; object-fit: cover;">
                                                <div class="form-check position-absolute" style="top: 5px; right: 5px;">
                                                    <input class="form-check-input" type="checkbox" 
                                                           name="delete_gallery[]" value="<?php echo e($index); ?>" 
                                                           id="delete_gallery_<?php echo e($index); ?>">
                                                    <label class="form-check-label text-white" for="delete_gallery_<?php echo e($index); ?>" 
                                                           style="text-shadow: 1px 1px 2px rgba(0,0,0,0.8);">
                                                        <i class="fas fa-trash"></i>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                <small class="text-muted">حدد الصور التي تريد حذفها</small>
                            </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label for="sort_order" class="form-label">الترتيب</label>
                            <input type="number" class="form-control <?php $__errorArgs = ['sort_order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="sort_order" name="sort_order" value="<?php echo e(old('sort_order', $portfolioItem->sort_order)); ?>">
                            <?php $__errorArgs = ['sort_order'];
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

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_featured" 
                                       name="is_featured" value="1" <?php echo e(old('is_featured', $portfolioItem->is_featured) ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="is_featured">
                                    عمل مميز
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> حفظ التغييرات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<script>
function validateImage(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        
        if (!validTypes.includes(file.type)) {
            alert('يرجى اختيار ملف صورة صالح (JPEG, PNG, JPG, GIF)');
            input.value = '';
            return false;
        }
        
        if (file.size > 2048 * 1024) { // 2MB
            alert('حجم الملف كبير جداً. الحد الأقصى 2 ميجابايت');
            input.value = '';
            return false;
        }
    }
    return true;
}

function validateGallery(input) {
    if (input.files && input.files.length > 0) {
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        
        for (let i = 0; i < input.files.length; i++) {
            const file = input.files[i];
            
            if (!validTypes.includes(file.type)) {
                alert('يرجى اختيار ملفات صورة صالحة (JPEG, PNG, JPG, GIF)');
                input.value = '';
                return false;
            }
            
            if (file.size > 2048 * 1024) { // 2MB
                alert('حجم الملف كبير جداً. الحد الأقصى 2 ميجابايت');
                input.value = '';
                return false;
            }
        }
    }
    return true;
}

// Handle image loading errors
document.addEventListener('DOMContentLoaded', function() {
    // Handle portfolio images
    document.querySelectorAll('.portfolio-image, .portfolio-gallery-image').forEach(function(img) {
        img.addEventListener('error', function() {
            this.src = '<?php echo e(asset("images/default-image.png")); ?>';
        });
    });

    // Debug form submission
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const imageInput = document.getElementById('image');
            console.log('Image file:', imageInput.files[0]);
            console.log('Has file:', imageInput.files.length > 0);
        });
    }
});
</script>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\admin\portfolio\edit.blade.php ENDPATH**/ ?>