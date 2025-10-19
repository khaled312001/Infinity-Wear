

<?php $__env->startSection('title', 'إدارة المحتوى'); ?>
<?php $__env->startSection('dashboard-title', 'لوحة الإدارة'); ?>
<?php $__env->startSection('page-title', 'إدارة المحتوى'); ?>
<?php $__env->startSection('page-subtitle', 'إدارة محتوى الموقع وإعدادات الـ SEO'); ?>
<?php $__env->startSection('profile-route', '#'); ?>
<?php $__env->startSection('settings-route', '#'); ?>

<?php $__env->startPush('head'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('sidebar-menu'); ?>
    <?php echo $__env->make('partials.admin-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-actions'); ?>
    <div class="d-flex gap-2">
        <a href="<?php echo e(route('admin.content.seo')); ?>" class="btn btn-outline-primary">
            <i class="fas fa-search-plus me-2"></i>
            إعدادات SEO
        </a>
        <button class="btn btn-outline-warning" onclick="clearCache()">
            <i class="fas fa-broom me-2"></i>
            مسح الكاش
        </button>
        <button class="btn btn-outline-info" onclick="generateSitemap()">
            <i class="fas fa-sitemap me-2"></i>
            إنشاء خريطة الموقع
        </button>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="h3 mb-1 text-dark">
                        <i class="fas fa-file-alt text-primary me-3"></i>
                        إدارة المحتوى
                    </h2>
                    <p class="text-muted mb-0">إدارة محتوى الموقع وإعدادات الـ SEO وتحسين الأداء</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-gradient-primary text-white border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-file-alt fa-2x opacity-75"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title mb-1">عدد الصفحات</h6>
                            <h3 class="mb-0"><?php echo e($stats['pages_count'] ?? 0); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-gradient-success text-white border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-search fa-2x opacity-75"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title mb-1">حالة SEO</h6>
                            <h3 class="mb-0"><?php echo e($stats['seo_status'] ?? 0); ?>%</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-gradient-warning text-white border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-database fa-2x opacity-75"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title mb-1">حجم الكاش</h6>
                            <h3 class="mb-0"><?php echo e($stats['cache_size'] ?? '0 KB'); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-gradient-info text-white border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-clock fa-2x opacity-75"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title mb-1">آخر تحديث</h6>
                            <h3 class="mb-0 small"><?php echo e($stats['last_update'] ?? 'غير محدد'); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Content Management Tools -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-tools me-2 text-primary"></i>
                        أدوات إدارة المحتوى
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <!-- SEO Management -->
                        <div class="col-md-6">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-search-plus fa-3x text-primary"></i>
                                    </div>
                                    <h5 class="card-title">إدارة SEO</h5>
                                    <p class="card-text text-muted">إدارة إعدادات محركات البحث وتحسين الظهور</p>
                                    <a href="<?php echo e(route('admin.content.seo')); ?>" class="btn btn-primary">
                                        <i class="fas fa-arrow-left me-2"></i>
                                        إدارة SEO
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Sitemap Management -->
                        <div class="col-md-6">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-sitemap fa-3x text-success"></i>
                                    </div>
                                    <h5 class="card-title">خريطة الموقع</h5>
                                    <p class="card-text text-muted">إنشاء وإدارة خريطة الموقع لمحركات البحث</p>
                                    <button class="btn btn-success" onclick="generateSitemap()">
                                        <i class="fas fa-plus me-2"></i>
                                        إنشاء خريطة الموقع
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Cache Management -->
                        <div class="col-md-6">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-broom fa-3x text-warning"></i>
                                    </div>
                                    <h5 class="card-title">إدارة الكاش</h5>
                                    <p class="card-text text-muted">مسح الكاش لتحسين أداء الموقع</p>
                                    <button class="btn btn-warning" onclick="clearCache()">
                                        <i class="fas fa-trash me-2"></i>
                                        مسح الكاش
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Content Management -->
                        <div class="col-md-6">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-layer-group fa-3x text-info"></i>
                                    </div>
                                    <h5 class="card-title">إدارة المحتوى المجمعة</h5>
                                    <p class="card-text text-muted">إدارة المحتوى الشامل للموقع</p>
                                    <a href="<?php echo e(route('admin.content-management.index')); ?>" class="btn btn-info">
                                        <i class="fas fa-arrow-left me-2"></i>
                                        إدارة المحتوى
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Sidebar -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-info text-white border-0">
                    <h6 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>
                        إجراءات سريعة
                    </h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="<?php echo e(route('admin.content.seo')); ?>" class="list-group-item list-group-item-action border-0">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-search-plus text-primary me-3"></i>
                                <div>
                                    <h6 class="mb-1">إعدادات SEO</h6>
                                    <small class="text-muted">تحسين محركات البحث</small>
                                </div>
                            </div>
                        </a>

                        <a href="<?php echo e(route('admin.content-management.index')); ?>" class="list-group-item list-group-item-action border-0">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-layer-group text-success me-3"></i>
                                <div>
                                    <h6 class="mb-1">إدارة المحتوى</h6>
                                    <small class="text-muted">إدارة المحتوى الشامل</small>
                                </div>
                            </div>
                        </a>

                        <button class="list-group-item list-group-item-action border-0" onclick="clearCache()">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-broom text-warning me-3"></i>
                                <div>
                                    <h6 class="mb-1">مسح الكاش</h6>
                                    <small class="text-muted">تحسين الأداء</small>
                                </div>
                            </div>
                        </button>

                        <button class="list-group-item list-group-item-action border-0" onclick="generateSitemap()">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-sitemap text-info me-3"></i>
                                <div>
                                    <h6 class="mb-1">خريطة الموقع</h6>
                                    <small class="text-muted">إنشاء خريطة الموقع</small>
                                </div>
                            </div>
                        </button>
                    </div>
                </div>
            </div>

            <!-- System Status -->
            <div class="card shadow-sm border-0 mt-3">
                <div class="card-header bg-gradient-success text-white border-0">
                    <h6 class="mb-0">
                        <i class="fas fa-heartbeat me-2"></i>
                        حالة النظام
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>حالة SEO</span>
                        <span class="badge bg-<?php echo e($stats['seo_status'] >= 80 ? 'success' : ($stats['seo_status'] >= 50 ? 'warning' : 'danger')); ?>">
                            <?php echo e($stats['seo_status'] ?? 0); ?>%
                        </span>
                    </div>
                    <div class="progress mb-3" style="height: 6px;">
                        <div class="progress-bar bg-<?php echo e($stats['seo_status'] >= 80 ? 'success' : ($stats['seo_status'] >= 50 ? 'warning' : 'danger')); ?>" 
                             style="width: <?php echo e($stats['seo_status'] ?? 0); ?>%"></div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>حجم الكاش</span>
                        <span class="text-muted"><?php echo e($stats['cache_size'] ?? '0 KB'); ?></span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <span>آخر تحديث</span>
                        <span class="text-muted small"><?php echo e($stats['last_update'] ?? 'غير محدد'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        }

        .bg-gradient-success {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%) !important;
        }

        .bg-gradient-warning {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%) !important;
        }

        .bg-gradient-info {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%) !important;
        }

        .card {
            border-radius: 15px;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
        }

        .list-group-item {
            border-radius: 10px !important;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
        }

        .list-group-item:hover {
            background: #f8fafc;
            transform: translateX(5px);
        }

        .btn {
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        function clearCache() {
            if (confirm('هل أنت متأكد من مسح الكاش؟ هذا الإجراء سيسرع الموقع ولكن قد يؤثر مؤقتاً على الأداء.')) {
                // إظهار مؤشر التحميل
                const button = event.target.closest('button');
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>جاري المسح...';
                button.disabled = true;

                fetch('<?php echo e(route("admin.content.clear-cache")); ?>', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert('تم مسح الكاش بنجاح', 'success');
                        // تحديث الإحصائيات
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showAlert(data.message || 'حدث خطأ أثناء مسح الكاش', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('حدث خطأ أثناء مسح الكاش', 'error');
                })
                .finally(() => {
                    // إعادة تعيين الزر
                    button.innerHTML = originalText;
                    button.disabled = false;
                });
            }
        }

        function generateSitemap() {
            if (confirm('هل تريد إنشاء خريطة الموقع؟ سيتم إنشاء ملف sitemap.xml في المجلد الرئيسي للموقع.')) {
                // إظهار مؤشر التحميل
                const button = event.target.closest('button');
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>جاري الإنشاء...';
                button.disabled = true;

                fetch('<?php echo e(route("admin.content.generate-sitemap")); ?>', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        let message = 'تم إنشاء خريطة الموقع بنجاح';
                        if (data.sitemap_url) {
                            message += `<br><a href="${data.sitemap_url}" target="_blank" class="text-white">عرض خريطة الموقع</a>`;
                        }
                        showAlert(message, 'success');
                    } else {
                        showAlert(data.message || 'حدث خطأ أثناء إنشاء خريطة الموقع', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('حدث خطأ أثناء إنشاء خريطة الموقع', 'error');
                })
                .finally(() => {
                    // إعادة تعيين الزر
                    button.innerHTML = originalText;
                    button.disabled = false;
                });
            }
        }

        function showAlert(message, type) {
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
            
            const alertHtml = `
                <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
                     style="top: 20px; right: 20px; z-index: 9999; min-width: 350px; max-width: 500px;">
                    <i class="fas ${icon} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', alertHtml);
            
            // إزالة التنبيه تلقائياً بعد 7 ثوان
            setTimeout(() => {
                const alert = document.querySelector('.alert');
                if (alert) {
                    alert.classList.remove('show');
                    setTimeout(() => alert.remove(), 300);
                }
            }, 7000);
        }

        // إضافة تأثيرات تفاعلية للأزرار
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('button[onclick]');
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    // تأثير النقر
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                    }, 150);
                });
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\admin\content\index.blade.php ENDPATH**/ ?>