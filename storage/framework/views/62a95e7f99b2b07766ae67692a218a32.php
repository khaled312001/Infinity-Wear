<?php $__env->startSection('title', 'إدارة التقييمات'); ?>
<?php $__env->startSection('dashboard-title', 'لوحة الإدارة'); ?>
<?php $__env->startSection('page-title', 'إدارة التقييمات'); ?>
<?php $__env->startSection('page-subtitle', 'عرض وإدارة جميع شهادات العملاء'); ?>
<?php $__env->startSection('profile-route', '#'); ?>
<?php $__env->startSection('settings-route', '#'); ?>

<?php $__env->startSection('sidebar-menu'); ?>
    <?php echo $__env->make('partials.admin-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-actions'); ?>
    <a href="<?php echo e(route('admin.testimonials.create')); ?>" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        إضافة تقييم جديد
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="dashboard-card">
        <div class="card-header bg-white border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-quote-left me-2 text-primary"></i>
                    جميع التقييمات
                </h5>
                <div class="d-flex gap-2">
                    <input type="text" class="form-control form-control-sm" placeholder="البحث في التقييمات..." id="searchInput">
                </div>
            </div>
        </div>
        <div class="card-body">
            <?php if($testimonials->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>صورة العميل</th>
                                <th>اسم العميل</th>
                                <th>المنصب</th>
                                <th>الشركة</th>
                                <th>التقييم</th>
                                <th>المحتوى</th>
                                <th>الحالة</th>
                                <th>ترتيب العرض</th>
                                <th>تاريخ الإنشاء</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if($testimonial->image): ?>
                                            <img src="<?php echo e(asset('storage/' . $testimonial->image)); ?>" 
                                                 alt="<?php echo e($testimonial->client_name); ?>" 
                                                 class="rounded-circle me-3" 
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 40px; height: 40px;">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <h6 class="mb-0"><?php echo e($testimonial->client_name); ?></h6>
                                    </div>
                                </td>
                                <td><?php echo e($testimonial->client_position ?? 'غير محدد'); ?></td>
                                <td><?php echo e($testimonial->client_company ?? 'غير محدد'); ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <?php if($i <= $testimonial->rating): ?>
                                                <i class="fas fa-star text-warning"></i>
                                            <?php else: ?>
                                                <i class="far fa-star text-muted"></i>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                        <span class="ms-2 text-muted">(<?php echo e($testimonial->rating); ?>/5)</span>
                                    </div>
                                </td>
                                <td><?php echo e(Str::limit($testimonial->content, 50)); ?></td>
                                <td>
                                    <?php if($testimonial->is_active): ?>
                                        <span class="badge bg-success">نشط</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">غير نشط</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-info"><?php echo e($testimonial->sort_order ?? 0); ?></span>
                                </td>
                                <td><?php echo e($testimonial->created_at->format('Y-m-d')); ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?php echo e(route('admin.testimonials.edit', $testimonial)); ?>" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?php echo e(route('admin.testimonials.destroy', $testimonial)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('هل أنت متأكد من حذف هذه التقييم؟')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    <?php echo e($testimonials->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-quote-left fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">لا توجد شهادات حتى الآن</h4>
                    <p class="text-muted mb-4">ابدأ بإضافة تقييم جديد لعرض آراء عملائك</p>
                    <a href="<?php echo e(route('admin.testimonials.create')); ?>" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>
                        إضافة تقييم جديد
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // البحث في التقييمات
    document.getElementById('searchInput').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\admin\testimonials\index.blade.php ENDPATH**/ ?>