

<?php $__env->startSection('title', 'إدارة الإعلامات'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-bell me-2"></i>
                        إدارة الإعلامات
                    </h1>
                    <p class="text-muted">إرسال وإدارة الإشعارات والإيميلات للمستخدمين</p>
                </div>
                <a href="<?php echo e(route('admin.notifications.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    إشعار جديد
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                إجمالي الإشعارات
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($stats['total']); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-bell fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                تم الإرسال
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($stats['sent']); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                في الانتظار
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($stats['pending']); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                مجدولة
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($stats['scheduled']); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">فلترة الإشعارات</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.notifications.index')); ?>">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="type">نوع الإرسال</label>
                            <select name="type" id="type" class="form-control">
                                <option value="">جميع الأنواع</option>
                                <option value="notification" <?php echo e(request('type') == 'notification' ? 'selected' : ''); ?>>إشعار فقط</option>
                                <option value="email" <?php echo e(request('type') == 'email' ? 'selected' : ''); ?>>إيميل فقط</option>
                                <option value="both" <?php echo e(request('type') == 'both' ? 'selected' : ''); ?>>إشعار وإيميل</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="priority">الأولوية</label>
                            <select name="priority" id="priority" class="form-control">
                                <option value="">جميع الأولويات</option>
                                <option value="low" <?php echo e(request('priority') == 'low' ? 'selected' : ''); ?>>منخفضة</option>
                                <option value="normal" <?php echo e(request('priority') == 'normal' ? 'selected' : ''); ?>>عادية</option>
                                <option value="high" <?php echo e(request('priority') == 'high' ? 'selected' : ''); ?>>عالية</option>
                                <option value="urgent" <?php echo e(request('priority') == 'urgent' ? 'selected' : ''); ?>>عاجلة</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status">الحالة</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">جميع الحالات</option>
                                <option value="sent" <?php echo e(request('status') == 'sent' ? 'selected' : ''); ?>>تم الإرسال</option>
                                <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>في الانتظار</option>
                                <option value="scheduled" <?php echo e(request('status') == 'scheduled' ? 'selected' : ''); ?>>مجدولة</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="search">البحث</label>
                            <input type="text" name="search" id="search" class="form-control" 
                                   value="<?php echo e(request('search')); ?>" placeholder="البحث في العنوان أو المحتوى">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>فلترة
                        </button>
                        <a href="<?php echo e(route('admin.notifications.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>مسح الفلاتر
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Notifications List -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">قائمة الإشعارات</h6>
        </div>
        <div class="card-body">
            <?php if($notifications->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>العنوان</th>
                                <th>النوع</th>
                                <th>المستهدفون</th>
                                <th>الأولوية</th>
                                <th>الحالة</th>
                                <th>تاريخ الإنشاء</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="font-weight-bold"><?php echo e($notification->title); ?></div>
                                                <?php if($notification->category): ?>
                                                    <small class="text-muted"><?php echo e($notification->category); ?></small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-<?php echo e($notification->type == 'notification' ? 'primary' : ($notification->type == 'email' ? 'success' : 'info')); ?>">
                                            <?php echo e($notification->type_label); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-secondary"><?php echo e($notification->target_type_label); ?></span>
                                        <?php if($notification->target_type === 'specific_users' && $notification->target_users): ?>
                                            <br><small class="text-muted"><?php echo e(count($notification->target_users)); ?> مستخدم</small>
                                        <?php elseif($notification->target_type === 'user_type' && $notification->target_user_types): ?>
                                            <br><small class="text-muted"><?php echo e(count($notification->target_user_types)); ?> نوع</small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge badge-<?php echo e($notification->priority_color); ?>">
                                            <?php echo e($notification->priority_label); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <?php if($notification->is_sent): ?>
                                            <span class="badge badge-success">
                                                <i class="fas fa-check me-1"></i>تم الإرسال
                                            </span>
                                            <?php if($notification->sent_count > 0): ?>
                                                <br><small class="text-muted"><?php echo e($notification->sent_count); ?> مستخدم</small>
                                            <?php endif; ?>
                                        <?php elseif($notification->is_scheduled): ?>
                                            <span class="badge badge-info">
                                                <i class="fas fa-calendar me-1"></i>مجدول
                                            </span>
                                            <br><small class="text-muted"><?php echo e($notification->scheduled_at->format('Y-m-d H:i')); ?></small>
                                        <?php else: ?>
                                            <span class="badge badge-warning">
                                                <i class="fas fa-clock me-1"></i>في الانتظار
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div><?php echo e($notification->created_at->format('Y-m-d')); ?></div>
                                        <small class="text-muted"><?php echo e($notification->created_at->format('H:i')); ?></small>
                                        <br><small class="text-muted">بواسطة <?php echo e($notification->creator->name); ?></small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo e(route('admin.notifications.show', $notification)); ?>" 
                                               class="btn btn-sm btn-info" title="عرض التفاصيل">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <?php if(!$notification->is_sent): ?>
                                                <form method="POST" action="<?php echo e(route('admin.notifications.send', $notification)); ?>" 
                                                      style="display: inline-block;">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="btn btn-sm btn-success" 
                                                            title="إرسال الآن" 
                                                            onclick="return confirm('هل تريد إرسال هذا الإشعار الآن؟')">
                                                        <i class="fas fa-paper-plane"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                            <form method="POST" action="<?php echo e(route('admin.notifications.destroy', $notification)); ?>" 
                                                  style="display: inline-block;"
                                                  onsubmit="return confirm('هل أنت متأكد من حذف هذا الإشعار؟')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-danger" title="حذف">
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
                <div class="d-flex justify-content-center">
                    <?php echo e($notifications->appends(request()->query())->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-bell fa-3x text-gray-300 mb-3"></i>
                    <h5 class="text-gray-600">لا توجد إشعارات</h5>
                    <p class="text-muted">لم يتم إنشاء أي إشعارات بعد</p>
                    <a href="<?php echo e(route('admin.notifications.create')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>إنشاء إشعار جديد
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function() {
    // Auto-submit form on filter change
    $('#type, #priority, #status').change(function() {
        $(this).closest('form').submit();
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\admin\notifications\index.blade.php ENDPATH**/ ?>