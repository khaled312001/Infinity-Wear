<?php $__env->startSection('title', 'إدارة المستخدمين'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Header Section -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">إدارة المستخدمين</h1>
                    <p class="text-muted">إدارة جميع المستخدمين في النظام</p>
                </div>
                <div>
                    <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i> إضافة مستخدم جديد
                    </a>
                    <a href="<?php echo e(route('admin.users.export', request()->query())); ?>" class="btn btn-outline-success">
                        <i class="fas fa-download"></i> تصدير
                    </a>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0"><?php echo e($stats['total']); ?></h4>
                                    <p class="mb-0">إجمالي المستخدمين</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-users fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0"><?php echo e($stats['active']); ?></h4>
                                    <p class="mb-0">المستخدمين النشطين</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-user-check fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0"><?php echo e($stats['inactive']); ?></h4>
                                    <p class="mb-0">المستخدمين غير النشطين</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-user-times fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-0"><?php echo e($stats['by_type']['importer'] ?? 0); ?></h4>
                                    <p class="mb-0">المستوردين</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-truck fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="<?php echo e(route('admin.users.index')); ?>">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="user_type" class="form-label">نوع المستخدم</label>
                                <select name="user_type" id="user_type" class="form-select">
                                    <option value="">جميع الأنواع</option>
                                    <option value="admin" <?php echo e(request('user_type') == 'admin' ? 'selected' : ''); ?>>مدير</option>
                                    <option value="employee" <?php echo e(request('user_type') == 'employee' ? 'selected' : ''); ?>>موظف</option>
                                    <option value="importer" <?php echo e(request('user_type') == 'importer' ? 'selected' : ''); ?>>مستورد</option>
                                    <option value="customer" <?php echo e(request('user_type') == 'customer' ? 'selected' : ''); ?>>عميل</option>
                                    <option value="sales" <?php echo e(request('user_type') == 'sales' ? 'selected' : ''); ?>>مندوب مبيعات</option>
                                    <option value="marketing" <?php echo e(request('user_type') == 'marketing' ? 'selected' : ''); ?>>موظف تسويق</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="status" class="form-label">الحالة</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="">جميع الحالات</option>
                                    <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>نشط</option>
                                    <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>غير نشط</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="search" class="form-label">البحث</label>
                                <input type="text" name="search" id="search" class="form-control" 
                                       placeholder="البحث بالاسم، البريد الإلكتروني، أو رقم الهاتف" 
                                       value="<?php echo e(request('search')); ?>">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> بحث
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Users Table -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">قائمة المستخدمين</h5>
                </div>
                <div class="card-body p-0">
                    <?php if($users->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>المستخدم</th>
                                        <th>نوع المستخدم</th>
                                        <th>البريد الإلكتروني</th>
                                        <th>رقم الهاتف</th>
                                        <th>المدينة</th>
                                        <th>الحالة</th>
                                        <th>تاريخ الإنشاء</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php if($user->avatar): ?>
                                                        <img src="<?php echo e(asset('storage/' . $user->avatar)); ?>" 
                                                             alt="<?php echo e($user->name); ?>" 
                                                             class="rounded-circle me-2" 
                                                             width="40" height="40">
                                                    <?php else: ?>
                                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                                                             style="width: 40px; height: 40px;">
                                                            <?php echo e(substr($user->name, 0, 1)); ?>

                                                        </div>
                                                    <?php endif; ?>
                                                    <div>
                                                        <h6 class="mb-0"><?php echo e($user->name); ?></h6>
                                                        <?php if($user->bio): ?>
                                                            <small class="text-muted"><?php echo e(Str::limit($user->bio, 30)); ?></small>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?php echo e($user->user_type == 'admin' ? 'danger' : ($user->user_type == 'importer' ? 'info' : 'secondary')); ?>">
                                                    <?php echo e($user->getUserTypeLabelAttribute()); ?>

                                                </span>
                                            </td>
                                            <td><?php echo e($user->email); ?></td>
                                            <td><?php echo e($user->phone ?? '-'); ?></td>
                                            <td><?php echo e($user->city ?? '-'); ?></td>
                                            <td>
                                                <?php if($user->is_active): ?>
                                                    <span class="badge bg-success">نشط</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">غير نشط</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e($user->created_at->format('Y-m-d')); ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?php echo e(route('admin.users.show', $user)); ?>" 
                                                       class="btn btn-sm btn-outline-info" 
                                                       title="عرض">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="<?php echo e(route('admin.users.edit', $user)); ?>" 
                                                       class="btn btn-sm btn-outline-primary" 
                                                       title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST" action="<?php echo e(route('admin.users.toggle-status', $user)); ?>" 
                                                          class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="submit" 
                                                                class="btn btn-sm btn-outline-<?php echo e($user->is_active ? 'warning' : 'success'); ?>"
                                                                title="<?php echo e($user->is_active ? 'إلغاء تفعيل' : 'تفعيل'); ?>"
                                                                onclick="return confirm('هل أنت متأكد من تغيير حالة المستخدم؟')">
                                                            <i class="fas fa-<?php echo e($user->is_active ? 'ban' : 'check'); ?>"></i>
                                                        </button>
                                                    </form>
                                                    <form method="POST" action="<?php echo e(route('admin.users.destroy', $user)); ?>" 
                                                          class="d-inline"
                                                          onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف">
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
                        <div class="card-footer">
                            <?php echo e($users->appends(request()->query())->links()); ?>

                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">لا توجد مستخدمين</h5>
                            <p class="text-muted">لم يتم العثور على مستخدمين مطابقين للبحث</p>
                            <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-primary">
                                <i class="fas fa-plus"></i> إضافة مستخدم جديد
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    // Auto-submit form on filter change
    document.getElementById('user_type').addEventListener('change', function() {
        this.form.submit();
    });
    
    document.getElementById('status').addEventListener('change', function() {
        this.form.submit();
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\admin\users\index.blade.php ENDPATH**/ ?>