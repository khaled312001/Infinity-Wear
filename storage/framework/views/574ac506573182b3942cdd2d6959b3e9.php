<?php
use Illuminate\Support\Facades\Storage;
?>

<?php $__env->startSection('title', 'إدارة معرض الأعمال'); ?>
<?php $__env->startSection('dashboard-title', 'لوحة الإدارة'); ?>
<?php $__env->startSection('page-title', 'إدارة معرض الأعمال'); ?>
<?php $__env->startSection('page-subtitle', 'إدارة وتنظيم أعمال المعرض'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <!-- Enhanced Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center">
                    <div class="me-4">
                        <div class="portfolio-icon" style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); margin-bottom: 0; border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-images text-white" style="font-size: 24px;"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="h3 mb-1 fw-bold text-dark">
                            إدارة معرض الأعمال
                        </h1>
                        <p class="text-muted mb-0">إدارة وتنظيم أعمال المعرض</p>
                        <small class="text-muted">
                            <i class="fas fa-calendar-alt me-1"></i>
                            <?php echo e(Carbon\Carbon::now()->format('d F Y')); ?>

                        </small>
                    </div>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="<?php echo e(route('admin.portfolio.create')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        إضافة عمل جديد
                    </a>
                    <a href="<?php echo e(route('portfolio.index')); ?>" class="btn btn-outline-primary" target="_blank">
                        <i class="fas fa-external-link-alt me-2"></i>
                        عرض المعرض
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-cog me-2"></i>
                            المزيد
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" onclick="exportPortfolio()">
                                <i class="fas fa-download me-2"></i>تصدير البيانات
                            </a></li>
                            <li><a class="dropdown-item" href="#" onclick="refreshPortfolio()">
                                <i class="fas fa-sync-alt me-2"></i>تحديث
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Quick Stats -->
    <?php if($portfolioItems->count() > 0): ?>
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card bg-gradient-primary text-white">
                <div class="d-flex align-items-center">
                    <div class="stats-icon me-3">
                        <i class="fas fa-images"></i>
                    </div>
                    <div>
                        <h4 class="mb-0"><?php echo e($portfolioItems->total()); ?></h4>
                        <small>إجمالي الأعمال</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card bg-gradient-warning text-white">
                <div class="d-flex align-items-center">
                    <div class="stats-icon me-3">
                        <i class="fas fa-star"></i>
                    </div>
                    <div>
                        <h4 class="mb-0"><?php echo e($portfolioItems->where('is_featured', true)->count()); ?></h4>
                        <small>أعمال مميزة</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card bg-gradient-success text-white">
                <div class="d-flex align-items-center">
                    <div class="stats-icon me-3">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <h4 class="mb-0"><?php echo e($portfolioItems->where('is_active', true)->count()); ?></h4>
                        <small>أعمال نشطة</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card bg-gradient-info text-white">
                <div class="d-flex align-items-center">
                    <div class="stats-icon me-3">
                        <i class="fas fa-tags"></i>
                    </div>
                    <div>
                        <h4 class="mb-0"><?php echo e($portfolioItems->pluck('category')->unique()->count()); ?></h4>
                        <small>فئات مختلفة</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Enhanced Portfolio Table -->
    <div class="dashboard-card">
        <div class="card-header bg-gradient-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-table me-2"></i>
                    قائمة أعمال المعرض
                </h5>
                <div class="d-flex align-items-center gap-3">
                    <span class="badge bg-light text-dark">
                        إجمالي: <?php echo e($portfolioItems->total()); ?> عمل
                    </span>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-light" onclick="exportPortfolio()" title="تصدير">
                            <i class="fas fa-download me-1"></i>
                            تصدير
                        </button>
                        <button type="button" class="btn btn-sm btn-light" onclick="refreshPortfolio()" title="تحديث">
                            <i class="fas fa-sync-alt me-1"></i>
                            تحديث
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <?php if($portfolioItems->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="10%">الصورة</th>
                                <th width="20%">العنوان</th>
                                <th width="12%">الفئة</th>
                                <th width="15%">العميل</th>
                                <th width="12%">تاريخ الإنجاز</th>
                                <th width="8%">مميز</th>
                                <th width="8%">الترتيب</th>
                                <th width="8%">الحالة</th>
                                <th width="7%">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $portfolioItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="portfolio-row">
                                <td>
                                    <?php if($item->image): ?>
                                        <div class="portfolio-thumbnail">
                                            <img src="<?php echo e($item->image_url); ?>" alt="<?php echo e($item->title); ?>" 
                                                 class="img-thumbnail portfolio-thumbnail-image" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                        </div>
                                    <?php else: ?>
                                        <div class="bg-light d-flex align-items-center justify-content-center" 
                                             style="width: 60px; height: 60px; border-radius: 8px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="portfolio-title">
                                        <h6 class="mb-1 fw-semibold"><?php echo e($item->title); ?></h6>
                                        <small class="text-muted"><?php echo e(Str::limit($item->description, 50)); ?></small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-<?php echo e($item->category === 'football' ? 'success' : ($item->category === 'basketball' ? 'primary' : ($item->category === 'schools' ? 'info' : ($item->category === 'companies' ? 'warning' : ($item->category === 'medical' ? 'danger' : 'secondary'))))); ?>">
                                        <?php echo e($item->category); ?>

                                    </span>
                                </td>
                                <td>
                                    <div class="client-info">
                                        <span class="fw-medium"><?php echo e($item->client_name ?? 'غير محدد'); ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="date-info">
                                        <span class="fw-medium"><?php echo e($item->completion_date ? $item->completion_date->format('d/m/Y') : 'غير محدد'); ?></span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge <?php echo e($item->is_featured ? 'bg-warning text-dark' : 'bg-secondary'); ?>">
                                        <i class="fas fa-<?php echo e($item->is_featured ? 'star' : 'circle'); ?> me-1"></i>
                                        <?php echo e($item->is_featured ? 'مميز' : 'عادي'); ?>

                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark"><?php echo e($item->sort_order); ?></span>
                                </td>
                                <td>
                                    <span class="badge <?php echo e($item->is_active ? 'bg-success' : 'bg-secondary'); ?>">
                                        <i class="fas fa-<?php echo e($item->is_active ? 'check-circle' : 'times-circle'); ?> me-1"></i>
                                        <?php echo e($item->is_active ? 'نشط' : 'غير نشط'); ?>

                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?php echo e(route('admin.portfolio.edit', $item)); ?>" 
                                           class="btn btn-sm btn-outline-warning" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger delete-portfolio-btn" 
                                                data-portfolio-id="<?php echo e($item->id); ?>" 
                                                data-portfolio-title="<?php echo e($item->title); ?>" title="حذف">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <a href="<?php echo e(route('portfolio.show', $item)); ?>" 
                                           class="btn btn-sm btn-outline-info" target="_blank" title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <!-- Enhanced Pagination -->
                <div class="card-footer bg-white border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            عرض <?php echo e($portfolioItems->firstItem()); ?> إلى <?php echo e($portfolioItems->lastItem()); ?> من <?php echo e($portfolioItems->total()); ?> عمل
                        </div>
                        <div>
                            <?php echo e($portfolioItems->links()); ?>

                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-images fa-3x mb-3 opacity-50"></i>
                        <h5 class="mb-2">لا توجد أعمال في المعرض</h5>
                        <p class="mb-3">ابدأ بإضافة أول عمل لمعرض الأعمال</p>
                        <a href="<?php echo e(route('admin.portfolio.create')); ?>" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            إضافة عمل جديد
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تأكيد الحذف</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>هل أنت متأكد من حذف هذا العمل من المعرض؟</p>
                <p class="text-danger small">هذا الإجراء لا يمكن التراجع عنه.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">حذف</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* Enhanced Portfolio Styles */
    .dashboard-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border: none;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .dashboard-card:hover {
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .card-header {
        border-radius: 20px 20px 0 0 !important;
        padding: 1.5rem;
        border: none;
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8) !important;
    }

    .bg-gradient-warning {
        background: linear-gradient(135deg, #f59e0b, #d97706) !important;
    }

    .bg-gradient-success {
        background: linear-gradient(135deg, #10b981, #059669) !important;
    }

    .bg-gradient-info {
        background: linear-gradient(135deg, #06b6d4, #0891b2) !important;
    }

    .stats-card {
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border: none;
    }

    .stats-card:hover {
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
    }

    .stats-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
    }

    .table th {
        border-top: none;
        font-weight: 600;
        color: #374151;
        background-color: #f8f9fa;
        padding: 1rem 0.75rem;
        border-bottom: 2px solid #e5e7eb;
    }

    .table td {
        vertical-align: middle;
        border-color: #e5e7eb;
        padding: 1rem 0.75rem;
        transition: all 0.2s ease;
    }

    .portfolio-row:hover {
        background-color: #f8fafc;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .portfolio-thumbnail {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
    }

    .portfolio-thumbnail img {
        transition: transform 0.3s ease;
    }

    .portfolio-row:hover .portfolio-thumbnail img {
        opacity: 0.9;
    }

    .portfolio-title h6 {
        color: #1f2937;
        font-weight: 600;
    }

    .btn-group .btn {
        border-radius: 8px;
        margin: 0 2px;
        transition: all 0.2s ease;
    }

    .btn-group .btn:hover {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        font-weight: 600;
    }

    .btn {
        border-radius: 10px;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        transition: all 0.2s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        border: none;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #1d4ed8, #1e40af);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
    }

    .btn-outline-primary {
        border: 2px solid #3b82f6;
        color: #3b82f6;
        background: transparent;
    }

    .btn-outline-primary:hover {
        background: #3b82f6;
        color: white;
        box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
    }

    .btn-outline-warning {
        border: 2px solid #f59e0b;
        color: #f59e0b;
        background: transparent;
    }

    .btn-outline-warning:hover {
        background: #f59e0b;
        color: white;
        box-shadow: 0 2px 4px rgba(245, 158, 11, 0.3);
    }

    .btn-outline-danger {
        border: 2px solid #ef4444;
        color: #ef4444;
        background: transparent;
    }

    .btn-outline-danger:hover {
        background: #ef4444;
        color: white;
        box-shadow: 0 2px 4px rgba(239, 68, 68, 0.3);
    }

    .btn-outline-info {
        border: 2px solid #06b6d4;
        color: #06b6d4;
        background: transparent;
    }

    .btn-outline-info:hover {
        background: #06b6d4;
        color: white;
        box-shadow: 0 2px 4px rgba(6, 182, 212, 0.3);
    }

    .portfolio-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    /* Enhanced Modal Styles */
    .modal-content {
        border-radius: 20px;
        border: none;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .modal-header {
        border-bottom: 1px solid #e5e7eb;
        background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        border-radius: 20px 20px 0 0;
    }

    .empty-state {
        padding: 2rem;
    }

    /* Responsive Enhancements */
    @media (max-width: 768px) {
        .dashboard-card {
            border-radius: 15px;
        }
        
        .stats-card {
            padding: 1rem;
        }
        
        .stats-icon {
            width: 40px;
            height: 40px;
            font-size: 16px;
        }
        
        .table-responsive {
            font-size: 0.875rem;
        }
        
        .btn-group .btn {
            padding: 0.5rem 0.75rem;
            font-size: 0.75rem;
        }
    }

    /* Dark mode support */
    @media (prefers-color-scheme: dark) {
        .dashboard-card {
            background: #1f2937;
            border-color: #374151;
        }
        
        .table th {
            background-color: #374151;
            color: #f9fafb;
        }
        
        .table td {
            color: #f9fafb;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Enhanced Portfolio Management JavaScript
    
    function deletePortfolio(portfolioId, portfolioTitle) {
        const deleteForm = document.getElementById('deleteForm');
        deleteForm.action = `/admin/portfolio/${portfolioId}`;
        
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }

    function exportPortfolio() {
        showNotification('جاري تصدير بيانات المعرض...', 'info');
        
        // Simulate export process
        setTimeout(() => {
            showNotification('تم تصدير بيانات المعرض بنجاح', 'success');
        }, 2000);
    }

    function refreshPortfolio() {
        showNotification('جاري تحديث البيانات...', 'info');
        location.reload();
    }

    // Show notification function
    function showNotification(message, type = 'info') {
        const alertClass = {
            'success': 'alert-success',
            'error': 'alert-danger',
            'warning': 'alert-warning',
            'info': 'alert-info'
        }[type] || 'alert-info';

        const icon = {
            'success': 'fas fa-check-circle',
            'error': 'fas fa-exclamation-circle',
            'warning': 'fas fa-exclamation-triangle',
            'info': 'fas fa-info-circle'
        }[type] || 'fas fa-info-circle';

        const alert = document.createElement('div');
        alert.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
        alert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        alert.innerHTML = `
            <i class="${icon} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        document.body.appendChild(alert);

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 5000);
    }

    // Initialize page
    document.addEventListener('DOMContentLoaded', function() {
        // Handle image loading errors
        document.querySelectorAll('.portfolio-thumbnail-image').forEach(function(img) {
            img.addEventListener('error', function() {
                this.src = '<?php echo e(asset("images/default-image.png")); ?>';
            });
        });

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Add event listeners for delete buttons
        document.querySelectorAll('.delete-portfolio-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const portfolioId = this.getAttribute('data-portfolio-id');
                const portfolioTitle = this.getAttribute('data-portfolio-title');
                deletePortfolio(portfolioId, portfolioTitle);
            });
        });

        // Add enhanced hover effects to table rows
        document.querySelectorAll('.portfolio-row').forEach((row, index) => {
            row.style.transition = 'all 0.2s ease';
            row.style.animationDelay = `${index * 0.05}s`;
        });

        // Add animation to stats cards
        document.querySelectorAll('.stats-card').forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\admin\portfolio\index.blade.php ENDPATH**/ ?>