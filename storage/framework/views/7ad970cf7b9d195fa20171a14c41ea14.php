<?php $__env->startSection('title', 'إدارة الصلاحيات'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">إدارة الصلاحيات والأدوار</h4>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRoleModal">
                            <i class="fas fa-plus me-2"></i>إضافة دور جديد
                        </button>
                        <a href="<?php echo e(route('admin.permissions.reset')); ?>" class="btn btn-warning" 
                           onclick="return confirm('هل أنت متأكد من إعادة تعيين جميع الصلاحيات؟')">
                            <i class="fas fa-undo me-2"></i>إعادة تعيين
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo e(session('error')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Tabs for different user types -->
                    <ul class="nav nav-tabs" id="permissionsTabs" role="tablist">
                        <?php $__currentLoopData = $permissionsByUserType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userType => $permissions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?php echo e($loop->first ? 'active' : ''); ?>" 
                                        id="<?php echo e($userType); ?>-tab" 
                                        data-bs-toggle="tab" 
                                        data-bs-target="#<?php echo e($userType); ?>" 
                                        type="button" 
                                        role="tab">
                                    <?php switch($userType):
                                        case ('admin'): ?>
                                            <i class="fas fa-user-shield me-2"></i>الأدمن
                                            <?php break; ?>
                                        <?php case ('sales'): ?>
                                            <i class="fas fa-chart-line me-2"></i>المبيعات
                                            <?php break; ?>
                                        <?php case ('marketing'): ?>
                                            <i class="fas fa-bullhorn me-2"></i>التسويق
                                            <?php break; ?>
                                        <?php case ('customer'): ?>
                                            <i class="fas fa-user me-2"></i>العملاء
                                            <?php break; ?>
                                        <?php case ('importer'): ?>
                                            <i class="fas fa-industry me-2"></i>المستوردين
                                            <?php break; ?>
                                        <?php default: ?>
                                            <?php echo e(ucfirst($userType)); ?>

                                    <?php endswitch; ?>
                                </button>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>

                    <div class="tab-content" id="permissionsTabsContent">
                        <?php $__currentLoopData = $permissionsByUserType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userType => $permissions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="tab-pane fade <?php echo e($loop->first ? 'show active' : ''); ?>" 
                                 id="<?php echo e($userType); ?>" 
                                 role="tabpanel">
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h5 class="mb-3">الصلاحيات المتاحة لـ <?php echo e($permissions->first()->display_name ?? ucfirst($userType)); ?></h5>
                                        
                                        <div class="row">
                                            <?php $__currentLoopData = $permissions->groupBy('module'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module => $modulePermissions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="col-md-6 col-lg-4 mb-4">
                                                    <div class="card border">
                                                        <div class="card-header bg-light">
                                                            <h6 class="mb-0"><?php echo e(ucfirst($module)); ?></h6>
                                                        </div>
                                                        <div class="card-body">
                                                            <?php $__currentLoopData = $modulePermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" 
                                                                           type="checkbox" 
                                                                           value="<?php echo e($permission->id); ?>" 
                                                                           id="permission_<?php echo e($permission->id); ?>"
                                                                           disabled>
                                                                    <label class="form-check-label" for="permission_<?php echo e($permission->id); ?>">
                                                                        <?php echo e($permission->display_name); ?>

                                                                    </label>
                                                                    <?php if($permission->description): ?>
                                                                        <small class="text-muted d-block"><?php echo e($permission->description); ?></small>
                                                                    <?php endif; ?>
                                                                </div>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <!-- Roles Management Section -->
                    <div class="mt-5">
                        <h5 class="mb-3">إدارة الأدوار</h5>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>اسم الدور</th>
                                        <th>الاسم المعروض</th>
                                        <th>الوصف</th>
                                        <th>عدد الصلاحيات</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <span class="badge bg-primary"><?php echo e($role->name); ?></span>
                                            </td>
                                            <td><?php echo e($role->display_name); ?></td>
                                            <td><?php echo e($role->description); ?></td>
                                            <td>
                                                <span class="badge bg-info"><?php echo e($role->permissions->count()); ?></span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-outline-primary" 
                                                            onclick="editRole(<?php echo e($role->id); ?>, '<?php echo e($role->display_name); ?>', '<?php echo e($role->description); ?>', [<?php echo e($role->permissions->pluck('id')->implode(',')); ?>])">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <?php if(!in_array($role->name, ['super_admin', 'admin', 'sales', 'marketing', 'customer', 'importer'])): ?>
                                                        <button type="button" class="btn btn-outline-danger" 
                                                                onclick="deleteRole(<?php echo e($role->id); ?>)">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Role Modal -->
<div class="modal fade" id="createRoleModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?php echo e(route('admin.permissions.store-role')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title">إضافة دور جديد</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">اسم الدور (إنجليزي)</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="display_name" class="form-label">الاسم المعروض</label>
                                <input type="text" class="form-control" id="display_name" name="display_name" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">الوصف</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الصلاحيات</label>
                        <div class="row">
                            <?php $__currentLoopData = $permissionsByUserType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userType => $permissions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-6">
                                    <h6><?php echo e(ucfirst($userType)); ?></h6>
                                    <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                   value="<?php echo e($permission->id); ?>" 
                                                   name="permissions[]" 
                                                   id="create_permission_<?php echo e($permission->id); ?>">
                                            <label class="form-check-label" for="create_permission_<?php echo e($permission->id); ?>">
                                                <?php echo e($permission->display_name); ?>

                                            </label>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Role Modal -->
<div class="modal fade" id="editRoleModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editRoleForm" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-header">
                    <h5 class="modal-title">تعديل الدور</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_display_name" class="form-label">الاسم المعروض</label>
                                <input type="text" class="form-control" id="edit_display_name" name="display_name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_description" class="form-label">الوصف</label>
                                <input type="text" class="form-control" id="edit_description" name="description">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الصلاحيات</label>
                        <div class="row">
                            <?php $__currentLoopData = $permissionsByUserType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userType => $permissions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-6">
                                    <h6><?php echo e(ucfirst($userType)); ?></h6>
                                    <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="form-check">
                                            <input class="form-check-input edit-permission" type="checkbox" 
                                                   value="<?php echo e($permission->id); ?>" 
                                                   name="permissions[]" 
                                                   id="edit_permission_<?php echo e($permission->id); ?>">
                                            <label class="form-check-label" for="edit_permission_<?php echo e($permission->id); ?>">
                                                <?php echo e($permission->display_name); ?>

                                            </label>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editRole(roleId, displayName, description, permissionIds) {
    document.getElementById('editRoleForm').action = `/admin/permissions/roles/${roleId}`;
    document.getElementById('edit_display_name').value = displayName;
    document.getElementById('edit_description').value = description;
    
    // Clear all checkboxes
    document.querySelectorAll('.edit-permission').forEach(checkbox => {
        checkbox.checked = false;
    });
    
    // Check the role's permissions
    permissionIds.forEach(permissionId => {
        const checkbox = document.getElementById(`edit_permission_${permissionId}`);
        if (checkbox) {
            checkbox.checked = true;
        }
    });
    
    new bootstrap.Modal(document.getElementById('editRoleModal')).show();
}

function deleteRole(roleId) {
    if (confirm('هل أنت متأكد من حذف هذا الدور؟')) {
        fetch(`/admin/permissions/roles/${roleId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'حدث خطأ أثناء حذف الدور');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء حذف الدور');
        });
    }
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views/admin/permissions/index.blade.php ENDPATH**/ ?>