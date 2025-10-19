

<?php $__env->startSection('title', 'تفاصيل الإشعار'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-bell me-2"></i>
                        تفاصيل الإشعار
                    </h1>
                    <p class="text-muted">عرض تفاصيل الإشعار ونتائج الإرسال</p>
                </div>
                <div>
                    <a href="<?php echo e(route('admin.notifications.index')); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-right me-2"></i>
                        العودة للقائمة
                    </a>
                    <?php if(!$notification->is_sent): ?>
                        <form method="POST" action="<?php echo e(route('admin.notifications.send', $notification)); ?>" 
                              style="display: inline-block;">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-success" 
                                    onclick="return confirm('هل تريد إرسال هذا الإشعار الآن؟')">
                                <i class="fas fa-paper-plane me-2"></i>
                                إرسال الآن
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Notification Details -->
        <div class="col-lg-8">
            <!-- Basic Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">معلومات الإشعار</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="text-primary mb-3"><?php echo e($notification->title); ?></h4>
                            <?php if($notification->category): ?>
                                <span class="badge badge-secondary mb-3"><?php echo e($notification->category); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-4 text-right">
                            <span class="badge badge-<?php echo e($notification->priority_color); ?> badge-lg">
                                <?php echo e($notification->priority_label); ?>

                            </span>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h6 class="font-weight-bold text-gray-800">محتوى الإشعار:</h6>
                        <div class="bg-light p-3 rounded">
                            <?php echo e($notification->message); ?>

                        </div>
                    </div>

                    <?php if($notification->email_content): ?>
                        <div class="mb-4">
                            <h6 class="font-weight-bold text-gray-800">محتوى الإيميل:</h6>
                            <div class="bg-light p-3 rounded">
                                <?php echo nl2br(e($notification->email_content)); ?>

                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Target Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">المستهدفون</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>نوع المستهدفين:</strong>
                            <span class="badge badge-info"><?php echo e($notification->target_type_label); ?></span>
                        </div>
                        <div class="col-md-6">
                            <strong>طريقة الإرسال:</strong>
                            <span class="badge badge-<?php echo e($notification->type == 'notification' ? 'primary' : ($notification->type == 'email' ? 'success' : 'info')); ?>">
                                <?php echo e($notification->type_label); ?>

                            </span>
                        </div>
                    </div>

                    <?php if($targetUsers->count() > 0): ?>
                        <h6 class="font-weight-bold text-gray-800 mb-3">
                            المستخدمين المستهدفين (<?php echo e($targetUsers->count()); ?> مستخدم):
                        </h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>الاسم</th>
                                        <th>الإيميل</th>
                                        <th>النوع</th>
                                        <th>الحالة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $targetUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($user->name); ?></td>
                                            <td><?php echo e($user->email); ?></td>
                                            <td>
                                                <span class="badge badge-secondary"><?php echo e($user->user_type_label); ?></span>
                                            </td>
                                            <td>
                                                <span class="badge badge-success">نشط</span>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            لا يوجد مستخدمين مستهدفين
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Send Results -->
            <?php if($notification->is_sent && $notification->send_results): ?>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">نتائج الإرسال</h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="text-center">
                                    <div class="h4 text-success"><?php echo e($notification->sent_count); ?></div>
                                    <div class="text-muted">تم الإرسال بنجاح</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <div class="h4 text-danger"><?php echo e($notification->failed_count); ?></div>
                                    <div class="text-muted">فشل في الإرسال</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <div class="h4 text-primary"><?php echo e($notification->sent_count + $notification->failed_count); ?></div>
                                    <div class="text-muted">إجمالي المحاولات</div>
                                </div>
                            </div>
                        </div>

                        <?php if($notification->failed_count > 0): ?>
                            <h6 class="font-weight-bold text-gray-800 mb-3">تفاصيل الأخطاء:</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr>
                                            <th>المستخدم</th>
                                            <th>الخطأ</th>
                                            <th>الوقت</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $notification->send_results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(!$result['success']): ?>
                                                <tr>
                                                    <td>
                                                        <?php
                                                            $user = $targetUsers->firstWhere('id', $result['user_id']);
                                                        ?>
                                                        <?php echo e($user ? $user->name : 'مستخدم غير موجود'); ?>

                                                    </td>
                                                    <td class="text-danger"><?php echo e($result['error']); ?></td>
                                                    <td><?php echo e(\Carbon\Carbon::parse($result['sent_at'])->format('Y-m-d H:i:s')); ?></td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar Information -->
        <div class="col-lg-4">
            <!-- Status Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">حالة الإشعار</h6>
                </div>
                <div class="card-body text-center">
                    <?php if($notification->is_sent): ?>
                        <div class="mb-3">
                            <i class="fas fa-check-circle fa-3x text-success"></i>
                        </div>
                        <h5 class="text-success">تم الإرسال</h5>
                        <p class="text-muted">تم إرسال الإشعار بنجاح</p>
                        <small class="text-muted">
                            في <?php echo e($notification->sent_at->format('Y-m-d H:i:s')); ?>

                        </small>
                    <?php elseif($notification->is_scheduled): ?>
                        <div class="mb-3">
                            <i class="fas fa-calendar fa-3x text-info"></i>
                        </div>
                        <h5 class="text-info">مجدول</h5>
                        <p class="text-muted">سيتم الإرسال في الوقت المحدد</p>
                        <small class="text-muted">
                            <?php echo e($notification->scheduled_at->format('Y-m-d H:i:s')); ?>

                        </small>
                    <?php else: ?>
                        <div class="mb-3">
                            <i class="fas fa-clock fa-3x text-warning"></i>
                        </div>
                        <h5 class="text-warning">في الانتظار</h5>
                        <p class="text-muted">لم يتم إرسال الإشعار بعد</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Details Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">التفاصيل</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>تاريخ الإنشاء:</strong><br>
                        <span class="text-muted"><?php echo e($notification->created_at->format('Y-m-d H:i:s')); ?></span>
                    </div>
                    
                    <div class="mb-3">
                        <strong>أنشأ بواسطة:</strong><br>
                        <span class="text-muted"><?php echo e($notification->creator->name); ?></span>
                    </div>

                    <?php if($notification->is_scheduled): ?>
                        <div class="mb-3">
                            <strong>مجدول للإرسال:</strong><br>
                            <span class="text-muted"><?php echo e($notification->scheduled_at->format('Y-m-d H:i:s')); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if($notification->is_sent): ?>
                        <div class="mb-3">
                            <strong>تم الإرسال في:</strong><br>
                            <span class="text-muted"><?php echo e($notification->sent_at->format('Y-m-d H:i:s')); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Actions Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">الإجراءات</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <?php if(!$notification->is_sent): ?>
                            <form method="POST" action="<?php echo e(route('admin.notifications.send', $notification)); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-success w-100" 
                                        onclick="return confirm('هل تريد إرسال هذا الإشعار الآن؟')">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    إرسال الآن
                                </button>
                            </form>
                        <?php endif; ?>

                        <a href="<?php echo e(route('admin.notifications.index')); ?>" class="btn btn-secondary w-100">
                            <i class="fas fa-arrow-right me-2"></i>
                            العودة للقائمة
                        </a>

                        <form method="POST" action="<?php echo e(route('admin.notifications.destroy', $notification)); ?>" 
                              onsubmit="return confirm('هل أنت متأكد من حذف هذا الإشعار؟')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash me-2"></i>
                                حذف الإشعار
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\admin\notifications\show.blade.php ENDPATH**/ ?>