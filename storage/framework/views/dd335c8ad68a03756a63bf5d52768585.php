

<?php $__env->startSection('title', 'التسويق بالبريد الإلكتروني'); ?>
<?php $__env->startSection('dashboard-title', 'لوحة الإدارة'); ?>
<?php $__env->startSection('page-title', 'التسويق بالبريد الإلكتروني'); ?>
<?php $__env->startSection('page-subtitle', 'إرسال رسائل تسويقية للعملاء والفرق'); ?>

<?php $__env->startSection('sidebar-menu'); ?>
    <?php echo $__env->make('partials.admin-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-actions'); ?>
    <div class="d-flex gap-2">
        <a href="<?php echo e(route('admin.email-marketing.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>
            إنشاء حملة جديدة
        </a>
        <button class="btn btn-outline-info" onclick="refreshStats()">
            <i class="fas fa-sync-alt me-2"></i>
            تحديث الإحصائيات
        </button>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .stats-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 15px;
        color: white;
        transition: transform 0.3s ease;
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
    }
    
    .stats-card .card-body {
        padding: 1.5rem;
    }
    
    .stats-number {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }
    
    .stats-label {
        font-size: 0.9rem;
        opacity: 0.9;
    }
    
    .stats-icon {
        font-size: 3rem;
        opacity: 0.3;
        position: absolute;
        top: 1rem;
        right: 1rem;
    }
    
    .feature-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }
    
    .feature-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }
    
    .feature-icon.primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .feature-icon.success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
    }
    
    .feature-icon.warning {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }
    
    .feature-icon.info {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }
    
    .quick-action-btn {
        border-radius: 10px;
        padding: 1rem;
        text-align: center;
        text-decoration: none;
        color: inherit;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    
    .quick-action-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        color: inherit;
        text-decoration: none;
    }
    
    .quick-action-btn.primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .quick-action-btn.success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
    }
    
    .quick-action-btn.warning {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }
    
    .quick-action-btn.info {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<!-- Header Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h2 class="h3 mb-1 text-dark">
                    <i class="fas fa-envelope-open-text text-primary me-3"></i>
                    التسويق بالبريد الإلكتروني
                </h2>
                <p class="text-muted mb-0">إرسال رسائل تسويقية وإعلانات للعملاء والفرق المختلفة</p>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card stats-card position-relative">
            <div class="card-body">
                <div class="stats-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stats-number" id="totalUsers"><?php echo e($userCounts['all']); ?></div>
                <div class="stats-label">إجمالي المستخدمين</div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card stats-card position-relative" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
            <div class="card-body">
                <div class="stats-icon">
                    <i class="fas fa-user-friends"></i>
                </div>
                <div class="stats-number" id="customerCount"><?php echo e($userCounts['customers']); ?></div>
                <div class="stats-label">العملاء</div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card stats-card position-relative" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <div class="card-body">
                <div class="stats-icon">
                    <i class="fas fa-industry"></i>
                </div>
                <div class="stats-number" id="importerCount"><?php echo e($userCounts['importers']); ?></div>
                <div class="stats-label">المستوردين</div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card stats-card position-relative" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <div class="card-body">
                <div class="stats-icon">
                    <i class="fas fa-users-cog"></i>
                </div>
                <div class="stats-number" id="teamCount"><?php echo e($userCounts['sales'] + $userCounts['marketing']); ?></div>
                <div class="stats-label">فريق العمل</div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt me-2"></i>
                    الإجراءات السريعة
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="<?php echo e(route('admin.email-marketing.create')); ?>" class="quick-action-btn primary d-block">
                            <i class="fas fa-plus-circle fa-2x mb-2"></i>
                            <h6>إنشاء حملة جديدة</h6>
                            <small>إرسال رسالة تسويقية جديدة</small>
                        </a>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="<?php echo e(route('admin.email-marketing.create')); ?>?type=customers" class="quick-action-btn success d-block">
                            <i class="fas fa-user-friends fa-2x mb-2"></i>
                            <h6>إرسال للعملاء</h6>
                            <small>رسالة مخصصة للعملاء فقط</small>
                        </a>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="<?php echo e(route('admin.email-marketing.create')); ?>?type=importers" class="quick-action-btn warning d-block">
                            <i class="fas fa-industry fa-2x mb-2"></i>
                            <h6>إرسال للمستوردين</h6>
                            <small>رسالة مخصصة للمستوردين</small>
                        </a>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="<?php echo e(route('admin.email-marketing.create')); ?>?type=teams" class="quick-action-btn info d-block">
                            <i class="fas fa-users-cog fa-2x mb-2"></i>
                            <h6>إرسال للفرق</h6>
                            <small>رسالة لفريق المبيعات والتسويق</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card feature-card">
            <div class="card-body text-center">
                <div class="feature-icon primary mx-auto">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h5 class="card-title">استهداف دقيق</h5>
                <p class="card-text">اختر الفئة المستهدفة بدقة - العملاء، المستوردين، أو فرق العمل</p>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6 mb-4">
        <div class="card feature-card">
            <div class="card-body text-center">
                <div class="feature-icon success mx-auto">
                    <i class="fas fa-palette"></i>
                </div>
                <h5 class="card-title">تصميم جميل</h5>
                <p class="card-text">واجهة سهلة الاستخدام مع إمكانية تخصيص المحتوى والتصميم</p>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6 mb-4">
        <div class="card feature-card">
            <div class="card-body text-center">
                <div class="feature-icon warning mx-auto">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h5 class="card-title">تتبع النتائج</h5>
                <p class="card-text">مراقبة معدلات الإرسال والوصول للحملات التسويقية</p>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6 mb-4">
        <div class="card feature-card">
            <div class="card-body text-center">
                <div class="feature-icon info mx-auto">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h5 class="card-title">آمن وموثوق</h5>
                <p class="card-text">نظام آمن لإرسال الرسائل مع حماية من الرسائل المزعجة</p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function refreshStats() {
    // Add loading state
    const btn = event.target.closest('button');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>جاري التحديث...';
    btn.disabled = true;
    
    // Simulate API call (replace with actual API call)
    setTimeout(() => {
        // Reset button
        btn.innerHTML = originalText;
        btn.disabled = false;
        
        // Show success message
        showAlert('تم تحديث الإحصائيات بنجاح', 'success');
    }, 2000);
}

function showAlert(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    // Insert at the top of the content
    const content = document.querySelector('.container-fluid .row:first-child');
    content.parentNode.insertBefore(alertDiv, content);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}
</script>
<?php $__env->stopPush(); ?>





<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\admin\email-marketing\index.blade.php ENDPATH**/ ?>